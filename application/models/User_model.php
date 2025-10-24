<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function get_all_users($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        return $this->db->get('user');
    }

    public function get_users() {
        $this->db->where('role_id', 1);
        return $this->db->get('user');
    }

    function add_user($param1 = "") {
        $data['email'] = sanitizer($this->input->post('email'));
        $data['name'] = sanitizer($this->input->post('name'));
        $data['password'] = sha1(sanitizer($this->input->post('password')));
        $data['address'] = sanitizer($this->input->post('address'));
        $data['phone'] = sanitizer($this->input->post('phone'));
        $data['website'] = sanitizer($this->input->post('website'));
        $data['about'] = sanitizer($this->input->post('about'));
        $social_links = array(
            'facebook' => sanitizer($this->input->post('facebook')),
            'twitter' => sanitizer($this->input->post('twitter')),
            'linkedin' => sanitizer($this->input->post('linkedin')),
        );
        $data['social'] = json_encode($social_links);
        $data['role_id'] = 1;
        $data['wishlists'] = '[]';
        $verification_code =  md5(rand(100000000, 200000000));
        $data['verification_code'] = $verification_code;

        $validity = $this->check_duplication('on_create', $data['email']);
        if($validity){
            if (strtolower($this->session->userdata('role')) == 'admin') {
                $data['is_verified'] = 1;
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->upload_user_image($user_id);
                $this->session->set_flashdata('flash_message', get_phrase('user_registration_successfully_done'));
            }else {
                $data['is_verified'] = 0;
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->upload_user_image($user_id);
                $this->email_model->send_email_verification_mail($data['email'], $verification_code);
                $this->session->set_flashdata('flash_message', get_phrase('your_registration_has_been_successfully_done').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address').'.');
            }
            
        }else {
            if($param1 == 'sign_up'){
                $this->db->where('email', $data['email']);
                $this->db->where('is_verified', 0);
                $unverified_user = $this->db->get('user');
                if($unverified_user->num_rows() > 0){
                    $unverified_user_row = $unverified_user->row_array();
                    $this->email_model->send_email_verification_mail($unverified_user_row['email'], $unverified_user_row['verification_code']);
                    $this->session->set_flashdata('flash_message', get_phrase('You have already registered').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address').'.');
                    return;
                }
            }
            $this->session->set_flashdata('error_message', get_phrase('this_email_id_has_been_taken'));
        }
        return;
    }

    function edit_user($user_id="") {
        $data['email'] = sanitizer($this->input->post('email'));
        $data['name'] = sanitizer($this->input->post('name'));
        $data['address'] = sanitizer($this->input->post('address'));
        $data['about'] = sanitizer($this->input->post('about'));
        $data['phone'] = sanitizer($this->input->post('phone'));
        $data['meta_pixel'] = sanitizer($this->input->post('meta_pixel'));
        $data['website'] = sanitizer($this->input->post('website'));
        $data['about'] = sanitizer($this->input->post('about'));
        $social_links = array(
            'facebook' => sanitizer($this->input->post('facebook')),
            'twitter' => sanitizer($this->input->post('twitter')),
            'linkedin' => sanitizer($this->input->post('linkedin')),
        );
        $data['social'] = json_encode($social_links);

        $validity = $this->check_duplication('on_update', $data['email'], $user_id);

        if($validity){
            $this->db->where('id', $user_id);
            $this->db->update('user', $data);
            $this->upload_user_image($user_id);
            $this->upload_user_background_image($user_id);
            $this->session->set_flashdata('flash_message', get_phrase('user_updated_successfully'));
        }else {
            $this->session->set_flashdata('error_message', get_phrase('this_email_id_has_been_taken'));
        }
        return;
    }

    public function upload_user_image($user_id="") {
        if (isset($_FILES['user_image']) && $_FILES['user_image']['name'] != "") {
            move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_image/'.$user_id.'.jpg');
        }
    }

     public function upload_user_background_image($user_id="") {
        if (isset($_FILES['user_background']) && $_FILES['user_background']['name'] != "") {
            move_uploaded_file($_FILES['user_background']['tmp_name'], 'uploads/user_background/'.$user_id.'.jpg');
        }
    }

    function get_user_thumbnail($user_id = "") {
        if (file_exists('uploads/user_image/'.$user_id.'.jpg')) {
            return base_url('uploads/user_image/'.$user_id.'.jpg');
        }else {
            return base_url('uploads/user_image/user.png');
        }
    }

    public function check_duplication($action = "", $email = "", $user_id = "") {
        $duplicate_email_check = $this->db->get_where('user', array('email' => $email));

        if ($action == 'on_create') {
            if ($duplicate_email_check->num_rows() > 0) {
                return false;
            }else {
                return true;
            }
        }elseif ($action == 'on_update') {
            if ($duplicate_email_check->num_rows() > 0) {
                if ($duplicate_email_check->row()->id == $user_id) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return true;
            }
        }
    }

    public function change_password($user_id="") {
        $data = array();
        if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
            $user_details = $this->get_all_users($user_id)->row_array();
            $current_password = sanitizer($this->input->post('current_password'));
            $new_password = sanitizer($this->input->post('new_password'));
            $confirm_password = sanitizer($this->input->post('confirm_password'));

            if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                $data['password'] = sha1($new_password);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                return;
            }
        }

        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
    }

    public function get_listing_by_user_id($user_id = ""){
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'active');
        return $this->db->get('listing');
    }

    public function listing_import(){
		
		$file_name = $_FILES['csv_file']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $filename_without_ext = pathinfo($file_name, PATHINFO_FILENAME).(bin2hex(random_bytes(3)));
		move_uploaded_file($_FILES['csv_file']['tmp_name'],'assets/importCSV/'.$filename_without_ext.'.'.$ext);
        // $user_data;

		if (($handle = fopen('assets/importCSV/'.$filename_without_ext.'.'.$ext, 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if($count > 0){
                    $user_data['code'] = bin2hex(random_bytes(16));
					$user_data['name'] = html_escape($all_data[0]);
					$user_data['email'] = html_escape($all_data[1]);
                    $this->db->where('id', html_escape($all_data[2]));
                    $catagory= $this->db->get('category');
                    if( $catagory->num_rows()>0)
                    {$user_data['categories'] = '["'.html_escape($all_data[2]).'"]';}
                    else
                    {
                        $by_default= $this->db->get('category')->row_array();
                        $user_data['categories'] ='["'.$by_default.'"]';
                    }
				
					$user_data['address'] = html_escape($all_data[3]);
					$user_data['phone'] = html_escape($all_data[4]);

                    $latitude=html_escape($all_data[5]);
                    $longitude=html_escape($all_data[6]);
                    if( $latitude!="" &&  $longitude!="" )
                    { 
                        $user_data['latitude'] = $latitude;
					    $user_data['longitude'] = $longitude;
                    }
                    else
                    {
                        $user_data['latitude'] = "40.714340351475286";
					    $user_data['longitude'] = "-73.93590002150955";

                    }
                    $listing_type=strtolower(html_escape($all_data[7]));
                    if($listing_type=='hotel' ||$listing_type=='restaurant' ||$listing_type=='general' ||$listing_type=='shop' ||$listing_type=='beauty' )
                    {   $user_data['listing_type'] = $listing_type;  }
                    else
                    {    $user_data['listing_type'] = "general";}

					$user_data['date_added'] = strtotime("now");
					$user_data['date_modified'] =strtotime("now");
                    $is_featured=strtolower(html_escape($all_data[8]));
                    if($is_featured=='yes')
                    {  $user_data['is_featured'] =1;  }
                    else
                    {$user_data['is_featured'] =0;}
					$user_data['social'] = '{"facebook":"In qui laborum excep","twitter":"Id aut aut assumend","linkedin":"Corporis consequatur"}';
					$user_data['user_id'] = $this->session->userdata('user_id');
                    if($this->session->userdata('role_id')==1)
                    {
                        $user_data['package_expiry_date'] = 'admin';
                        $user_data['status'] = 'active';
                    }
                    else
                    {
                        $this->db->where('user_id',$this->session->userdata('user_id'));
                        $package_expire_date= $this->db->get('package_purchased_history')->row_array();
                        $user_data['package_expiry_date'] = $package_expire_date['expired_date'];
                        
                        $user_data['status'] = 'pending';
                        

                    }

                    $user_data['amenities'] = '[]';
                    $user_data['photos'] = '[]';
                    $user_data['video_provider'] = 'youtube';
                  

                    $city_id=html_escape($all_data[9]);
                    if($city_id!="")
                    {
                        $this->db->where('id', $city_id);
                        $all_city_state_country_from_city_table= $this->db->get('city')->row_array();
                        $user_data['city_id'] = $all_city_state_country_from_city_table['id'];
                        $user_data['state_id'] = $all_city_state_country_from_city_table['state_id'];
                        $user_data['country_id'] =$all_city_state_country_from_city_table['country_id'];

                    }
                  
            
                    $this->db->insert('listing', $user_data);
				
				}
				$count++;
			}
			fclose($handle);

  
		}

	}

    public function get_user_meta_pixel_id($user_id="")
    {
        $this->db->where('id', $user_id);
        $info= $this->db->get('user');
        if($info->num_rows()>0)
        {
            $info=$info->row_array();
            $meta_pixel_id=$info['meta_pixel'];
            return  $meta_pixel_id;

        }
        else
        {
            return 0;
        }
      
    }

    public function listing_import_v2() {
    // --- 1) Subida segura ---
    if (empty($_FILES['csv_file']['tmp_name'])) {
        $this->session->set_flashdata('error_message', 'No se recibió archivo.');
        redirect(site_url('admin/listings'), 'refresh');
        return;
    }

    $tmpPath = $_FILES['csv_file']['tmp_name'];
    $origName = $_FILES['csv_file']['name'];
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    if ($ext !== 'csv') {
        $this->session->set_flashdata('error_message', 'El archivo debe ser .csv');
        redirect(site_url('admin/listings'), 'refresh');
        return;
    }

    $newName = pathinfo($origName, PATHINFO_FILENAME) . bin2hex(random_bytes(3)) . '.csv';
    $dest = FCPATH . 'assets/importCSV/' . $newName;
    if (!move_uploaded_file($tmpPath, $dest)) {
        $this->session->set_flashdata('error_message', 'No se pudo guardar el archivo.');
        redirect(site_url('admin/listings'), 'refresh');
        return;
    }

    // --- 2) Detectar delimitador ---
    $delimiter = $this->detect_csv_delimiter($dest); // ver helper más abajo

    // --- 3) Abrir como SplFileObject + CSV ---
    $file = new SplFileObject($dest);
    $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
    $file->setCsvControl($delimiter, '"', "\\");

    // --- 4) Leer encabezados y normalizarlos ---
    $headersRaw = $file->fgetcsv();
    if (!$headersRaw || count($headersRaw) < 2) {
        $this->session->set_flashdata('error_message', 'Encabezados inválidos.');
        redirect(site_url('admin/listings'), 'refresh');
        return;
    }
    $headers = array_map([$this, 'normalize_header'], $headersRaw);

    // Mapa de sinónimos -> clave canónica
    $syn = [
        'name' => ['name','nombre','title'],
        'email' => ['email','correo','mail'],
        'category_id' => ['category_id','category','categoryid'],
        'address' => ['address','direccion','dirección','address1'],
        'phone' => ['phone','telefono','tel','whatsapp'],
        'latitude' => ['latitude','lat'],
        'longitude' => ['longitude','long','lng','lon','longtitude'],
        'is_featured' => ['is_featured','featured','feature_status','featurestatus','isfeatured'],
        // sociales / extra
        'facebook' => ['facebook'],
        'twitter' => ['twitter'],
        'linkedin' => ['linkedin'],
        'instagram' => ['instagram'],
        'website' => ['website','web'],
        'whatsapp' => ['whatsapp_number','wa','celular','movil'],
    ];

    // Construir índice: header_index['name'] = posición, etc.
    $header_index = [];
    foreach ($syn as $canonical => $alts) {
        foreach ($alts as $alt) {
            $pos = array_search($this->normalize_header($alt), $headers, true);
            if ($pos !== false) { $header_index[$canonical] = $pos; break; }
        }
    }

    // --- 5) Validación mínima de columnas requeridas ---
    $required = ['name','category_id','address','phone'];
    foreach ($required as $req) {
        if (!array_key_exists($req, $header_index)) {
            $this->session->set_flashdata('error_message', "Falta la columna requerida: {$req}");
            redirect(site_url('admin/listings'), 'refresh');
            return;
        }
    }

    // --- 6) Procesar filas ---
    $ok = 0; $errors = [];
    $this->db->trans_start();
    $rowNum = 1; // ya leímos encabezados

    while (!$file->eof()) {
       $row = $file->fgetcsv();

    // Fin de archivo
    if ($row === false) { break; }

    // NUMERO FÍSICO de fila (incluye vacías): sube acá
    $rowNum++;

    // Saltar filas realmente vacías: ['', '', ...] o [null]
    if ($row === [null] || $this->row_is_empty($row)) {
        continue;
    }

    // Alinear tamaño
    if (count($row) < count($headers)) {
        $row = array_pad($row, count($headers), '');
    }

    // ---- desde aquí, lo tuyo igual ----
    $get = function($key) use ($header_index, $row) {
        if (!isset($header_index[$key])) return '';
        $val = trim((string)$row[$header_index[$key]]);
        if (substr($val, 0, 3) === "\xEF\xBB\xBF") { $val = substr($val, 3); }
        return $val;
    };

    $name   = $get('name');
    $email  = $get('email');
    $cat_id = $get('category_id');
    $addr   = $get('address');
    $phone  = $get('phone');

    if ($name === '' || $addr === '' || $cat_id === '') {
        $errors[] = "Fila {$rowNum}: faltan datos obligatorios (name/address/category_id).";
        continue;
    }

        // normalizar email
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Fila {$rowNum}: email inválido.";
            continue;
        }

        // validar categoría
        $this->db->where('id', $cat_id);
        $cat = $this->db->get('category');
        if ($cat->num_rows() === 0) {
            // usar la primera categoría como default (o una fija que tú definas)
            $defaultCat = $this->db->order_by('id','ASC')->get('category')->row_array();
            if (!$defaultCat) {
                $errors[] = "Fila {$rowNum}: category_id {$cat_id} no existe y no hay categoría por defecto.";
                continue;
            }
            $cat_id = $defaultCat['id'];
        }

        // lat/lng (acepta coma decimal)
        $lat = $this->normalize_geo($get('latitude'), 'lat', 6);
        $lng = $this->normalize_geo($get('longitude'), 'lng', 6);
        if ($lat === null || $lng === null) {
            $errors[] = "Fila {$rowNum}: lat/lng fuera de rango o con formato inválido.";
            continue;
        }

        if ($lat === '' || $lng === '') {
            // por defecto si faltan
            $lat = "40.714340351475286";
            $lng = "-73.93590002150955";
        }

        // listing_type
        $lt = 'general';

        // is_featured
        $featRaw = strtolower($get('is_featured'));
        $is_featured = in_array($featRaw, ['1','yes','si','sí','true'], true) ? 1 : 0;

        // city_id (opcional)
        $city_id = 3;
        $state_id = 3;
        $country_id = 47;

        $website = $get('website');

        // sociales y extras
        $social = [
            'facebook'  => $get('facebook'),
            'twitter'   => $get('twitter'),
            'linkedin'  => $get('linkedin'),
            'instagram' => $get('instagram'),
            'whatsapp'  => $get('whatsapp'),
        ];


        // construir payload final
        $user_data = [
            'code'            => bin2hex(random_bytes(16)),
            'name'            => $this->x($name),
            'email'           => $this->x($email),
            'categories'      => json_encode([$cat_id]), // <- CORRECTO (antes tenías el array entero!)
            'address'         => $this->x($addr),
            'phone'           => $this->x($phone),
            'latitude'        => $lat,
            'longitude'       => $lng,
            'listing_type'    => $lt,
            'date_added'      => time(),
            'date_modified'   => time(),
            'is_featured'     => $is_featured,
            'social'          => json_encode($social, JSON_UNESCAPED_SLASHES),
            'website'         => $website,
            'user_id'         => $this->session->userdata('user_id'),
            // si guardas opening_hours/tags en columnas propias, agrégalas aquí.
        ];

        if ($this->session->userdata('role_id') == 1) {
            $user_data['package_expiry_date'] = 'admin';
            $user_data['status'] = 'active';
        } else {
            $ph = $this->db->where('user_id',$this->session->userdata('user_id'))
                           ->order_by('id','DESC')->get('package_purchased_history')->row_array();
            $user_data['package_expiry_date'] = $ph ? $ph['expired_date'] : null;
            $user_data['status'] = 'pending';
        }

        $user_data['listing_thumbnail'] = 'thumbnail.png';
        $user_data['listing_cover']     = 'thumbnail.png';
        // si quieres fotos vacías:
        $user_data['photos']            = json_encode([]); // o deja como [] si luego no las usas


        if ($city_id) {
            $user_data['city_id'] = $city_id;
            if ($state_id)   $user_data['state_id'] = $state_id;
            if ($country_id) $user_data['country_id'] = $country_id;
        }

        // insertar
        $this->db->insert('listing', $user_data);
        $ok++;
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        return ['type' => 'error', 'msg' => 'Error transaccional. Intenta de nuevo.'];
    } else {
        $skipped = 0;
        // dentro del while, cuando haces `continue;` por fila vacía:
        $skipped++;

        // Al final:
        $msg = "{$ok} filas importadas.";
        if ($skipped) $msg .= "\n{$skipped} filas vacías omitidas.";
        if (!empty($errors)) {
            $msg .= "\nCon advertencias/errores en " . count($errors) . " filas:\n- " . implode("\n- ", $errors);
            return ['type' => 'error', 'msg' => $msg];
        }
        return ['type' => 'success', 'msg' => $msg];
    }
}

// ----------------- HELPERS PRIVADOS -----------------

private function detect_csv_delimiter($filePath) {
    $delims = [",", ";", "\t", "|"];
    $fh = fopen($filePath, 'r');
    $line = fgets($fh);
    fclose($fh);
    if ($line === false) return ",";

    // remove BOM
    if (substr($line, 0, 3) === "\xEF\xBB\xBF") { $line = substr($line, 3); }

    $best = ","; $bestCount = 0;
    foreach ($delims as $d) {
        $c = substr_count($line, $d);
        if ($c > $bestCount) { $bestCount = $c; $best = $d; }
    }
    return $best ?: ",";
}

private function normalize_header($h) {
    $h = trim(mb_strtolower($h));
    // quitar BOM si viene acá
    if (substr($h, 0, 3) === "\xEF\xBB\xBF") { $h = substr($h, 3); }
    // quitar acentos
    $h = iconv('UTF-8', 'ASCII//TRANSLIT', $h);
    // reemplazar espacios por guion bajo y limpiar
    $h = preg_replace('/\s+/', '_', $h);
    $h = preg_replace('/[^a-z0-9_]/', '', $h);
    return $h;
}

private function normalize_decimal($v) {
    $v = trim($v);
    if ($v === '') return '';
    // reemplaza coma decimal por punto solo si es claramente un número
    if (preg_match('/^-?\d+(?:[.,]\d+)?$/', $v)) {
        $v = str_replace(',', '.', $v);
    }
    return $v;
}

private function split_pipe($v) {
    $v = trim($v);
    if ($v === '') return [];
    $parts = array_map('trim', explode('|', $v));
    // eliminar vacíos
    return array_values(array_filter($parts, function($x){ return $x !== ''; }));
}

private function x($v) { return html_escape($v); }


private function normalize_geo($v, $type = 'lat', $decimals = 6) {
    $v = trim((string)$v);
    if ($v === '') return null;

    // Signo
    $sign = 1;
    if ($v[0] === '-') { $sign = -1; $v = substr($v, 1); }

    // Si tiene ambos separadores: el último es decimal, el resto miles
    if (strpos($v, '.') !== false && strpos($v, ',') !== false) {
        $lastDot = strrpos($v, '.');
        $lastCom = strrpos($v, ',');
        $pos = max($lastDot, $lastCom);
        $int  = preg_replace('/\D/', '', substr($v, 0, $pos));
        $frac = preg_replace('/\D/', '', substr($v, $pos + 1));
        $num  = ($int === '' ? '0' : $int) . '.' . $frac;
    }
    // Solo comas => decimal coma
    elseif (strpos($v, ',') !== false && substr_count($v, ',') === 1 && strpos($v, '.') === false) {
        $num = str_replace(',', '.', preg_replace('/[^\d,]/', '', $v));
    }
    // Solo puntos y MÁS de uno => Excel metió miles (e.g. 3.988.057)
    elseif (strpos($v, '.') !== false && substr_count($v, '.') > 1 && strpos($v, ',') === false) {
        $digits = preg_replace('/\D/', '', $v);
        if ($digits === '') return null;
        // Suponemos N decimales fijos (por defecto 6)
        if (strlen($digits) <= $decimals) {
            $num = '0.' . str_pad($digits, $decimals, '0', STR_PAD_LEFT);
        } else {
            $num = substr($digits, 0, -$decimals) . '.' . substr($digits, -$decimals);
        }
    }
    // Solo un punto o sin separadores => úsalo tal cual
    else {
        // Deja solo dígitos y punto
        $num = preg_replace('/[^\d.]/', '', $v);
        // Si no hay punto y parece miles (muchos dígitos), intenta reubicar decimales
        if ($num !== '' && strpos($num, '.') === false && strlen($num) > 3) {
            // Heurística: partir antes de los últimos N decimales
            $num = substr($num, 0, -$decimals) . '.' . substr($num, -$decimals);
        }
    }

    // A número
    if (!is_numeric($num)) return null;
    $val = $sign * (float)$num;

    // Validar rango
    $max = ($type === 'lat') ? 90 : 180;
    if (abs($val) > $max) return null;

    // Normaliza a N decimales
    return number_format($val, $decimals, '.', '');
}


	
private function row_is_empty($row) {
    if (!is_array($row)) return true;
    foreach ($row as $v) {
        if (trim((string)$v) !== '') return false;
    }
    return true;
}

}
