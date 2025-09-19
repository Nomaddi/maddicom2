<!-- Bottom Scripts -->
<script src="<?php echo base_url('assets/backend/js/gsap/main-gsap.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/bootstrap.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/joinable.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/resizeable.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/neon-api.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/toastr.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/fullcalendar/fullcalendar.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/bootstrap-datepicker.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/bootstrap-timepicker.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/fileinput.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/backend/js/datatable/js/jquery.dataTables.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/backend/js/datatable/js/dataTables.bootstrap.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/backend/js/datatable/buttons/js/dataTables.buttons.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/backend/js/datatable/buttons/js/buttons.bootstrap.js');?>"></script>

<!-- SELECT2 Scripts -->
<script src="<?php echo base_url('assets/backend/js/select2/select2.min.js');?>"></script>
<!-- COMENTADO: Archivo problemático -->
<!-- <script src="<?php echo base_url('assets/backend/js/select2/jquery.select2.min.js');?>"></script> -->
<!-- CDN REEMPLAZO para Select2 si es necesario -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?php echo base_url('assets/backend/js/neon-calendar.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/neon-chat.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/neon-custom.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/neon-demo.js');?>"></script>

<script src="<?php echo base_url('assets/backend/js/wysihtml5/wysihtml5-0.4.0pre.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/wysihtml5/bootstrap-wysihtml5.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/dropzone/dropzone.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/daterangepicker/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/daterangepicker/daterangepicker.js');?>"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="<?php echo base_url('assets/backend/js/bootstrap-tagsinput.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/typeahead.min.js'); ?>"></script>
<!-- ELIMINADO DUPLICADO: jquery.multi-select.js -->
<script src="<?php echo base_url('assets/backend/js/jquery.multi-select.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/icheck/icheck.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/bootstrap-colorpicker.min.js'); ?>"></script>

<!-- TRUMBOWYG - COMENTADO archivo problemático -->
<!-- <script src="<?php echo base_url('assets/jquery_text_editor/trumbowyg.min.js'); ?>"></script> -->
<!-- CDN REEMPLAZO para Trumbowyg -->
<script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/trumbowyg.min.js"></script>

<!-- SILENCIAR WARNING DE CKEDITOR -->
<script>
// Silenciar warnings de CKEditor ANTES de que se cargue
(function() {
    // Interceptar console.warn
    if (typeof console !== 'undefined' && console.warn) {
        var originalWarn = console.warn;
        console.warn = function(message) {
            if (typeof message === 'string' && 
                (message.includes('CKEditor') || message.includes('not secure') || message.includes('4.22.1'))) {
                return; // No mostrar warnings de CKEditor
            }
            originalWarn.apply(console, arguments);
        };
    }
    
    // Interceptar console.log también por si acaso
    if (typeof console !== 'undefined' && console.log) {
        var originalLog = console.log;
        console.log = function(message) {
            if (typeof message === 'string' && 
                (message.includes('CKEditor') && message.includes('not secure'))) {
                return;
            }
            originalLog.apply(console, arguments);
        };
    }
})();

// Cuando CKEditor esté listo, ocultar alertas visuales
document.addEventListener('DOMContentLoaded', function() {
    // Esperar a que CKEditor se cargue
    setTimeout(function() {
        if (typeof CKEDITOR !== 'undefined') {
            // Ocultar alertas de notificación
            CKEDITOR.on('instanceReady', function(event) {
                var editor = event.editor;
                
                // Remover alertas visuales
                setTimeout(function() {
                    // Buscar y ocultar alertas de seguridad
                    var alerts = document.querySelectorAll('.cke_notification_warning, .cke_notification, [class*="cke_notification"]');
                    alerts.forEach(function(alert) {
                        if (alert.textContent && alert.textContent.includes('not secure')) {
                            alert.style.display = 'none';
                        }
                    });
                    
                    // También buscar por contenido de texto
                    var allDivs = document.querySelectorAll('div');
                    allDivs.forEach(function(div) {
                        if (div.textContent && div.textContent.includes('CKEditor 4.22.1 version is not secure')) {
                            div.style.display = 'none';
                        }
                    });
                }, 1000);
            });
            
            // Interceptar el sistema de notificaciones de CKEditor
            if (CKEDITOR.plugins && CKEDITOR.plugins.notification) {
                var originalShow = CKEDITOR.plugins.notification.prototype.show;
                if (originalShow) {
                    CKEDITOR.plugins.notification.prototype.show = function() {
                        // No mostrar notificaciones de seguridad
                        return this;
                    };
                }
            }
        }
    }, 500);
    
    // Observer para detectar nuevas alertas que se agreguen dinámicamente
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) { // Element node
                    // Buscar alertas de CKEditor
                    if (node.textContent && node.textContent.includes('not secure')) {
                        node.style.display = 'none';
                    }
                    
                    // Buscar en hijos también
                    var childAlerts = node.querySelectorAll ? node.querySelectorAll('*') : [];
                    for (var i = 0; i < childAlerts.length; i++) {
                        if (childAlerts[i].textContent && childAlerts[i].textContent.includes('not secure')) {
                            childAlerts[i].style.display = 'none';
                        }
                    }
                }
            });
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

// CSS para ocultar alertas por clase o contenido
var style = document.createElement('style');
style.textContent = `
    /* Ocultar alertas de CKEditor */
    .cke_notification_warning,
    .cke_notification,
    [class*="cke_notification"] {
        display: none !important;
    }
    
    /* Ocultar por contenido */
    div:has-text("not secure"),
    div:has-text("CKEditor 4.22.1") {
        display: none !important;
    }
`;
document.head.appendChild(style);
</script>

<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>
<script type="text/javascript">
	toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>
<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>
<script type="text/javascript">
	toastr.error('<?php echo $this->session->flashdata("error_message");?>');
</script>
<?php endif;?>

<!-- Toastr and alert notifications scripts -->
<script type="text/javascript">
function notify(message) {
  toastr.error(message);
}

function success_notify(message) {
  toastr.success(message);
}

function error_notify(message) {
  toastr.error(message);
}
</script>

<script src="<?php echo base_url('assets/backend/js/font-awesome-icon-picker/fontawesome-iconpicker.min.js'); ?>" charset="utf-8"></script>
<script src="<?php echo base_url('assets/frontend/js/bootstrap-tagsinput.min.js');?>" charset="utf-8"></script>
<script src="<?php echo base_url('assets/backend/js/ui/component.fileupload.js');?>" charset="utf-8"></script>
<script src="<?php echo site_url('assets/backend/js/custom.js');?>"></script>

<!-- Dashboard chart's data is coming from this file -->
<?php include 'admin/dashboard-chart.php'; ?>

<!---  DATA TABLE EXPORT CONFIGURATIONS -->
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		var datatable = $("#table_export").dataTable();
	});
  $(function() {
   $('.icon-picker').iconpicker();
 });
</script>