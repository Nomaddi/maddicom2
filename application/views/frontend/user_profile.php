<style type="text/css">
    .h-auto{
        height: auto;
    }
    .user-bg-img-card{
        height: 200px;
    }
    .user-bg-img{
        box-shadow: 0px 0px 20px -8px #000;
        margin-left: 20px;
        margin-top: 145px;
        border: 5px solid #fff;
    }
    .user-name-for-profile{
        color: white;
        margin-left: 120px;
        margin-top: -85px;
        font-size: 22px;
    }
    .user-bg-img-card{
        /*background-color: rgba(255,255,255,0.6);
        background-blend-mode: lighten;*/
    }
    @media screen and (min-width: 581px) {
        .user-bg-img-card{
            background-size: 100% 100%;
        }
    }

    @media screen and (max-width: 580px) {
        .user-bg-img-card{
            background-size: auto 100%;
        }
    }

    .font-12{
        font-size: 12px;
    }
</style>
<?php
    if(file_exists('uploads/user_background/'.$user_details['id'].'.jpg')):
        $bg_img = base_url('uploads/user_background/'.$user_details['id'].'.jpg');
    else:
        $bg_img = base_url('uploads/user_background/thumbnail.png');
    endif;
    $user_listings = $this->user_model->get_listing_by_user_id($user_details['id']);
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="user-bg-img-card mb-5" style="background-image: url('<?php echo $bg_img; ?>'); background-repeat: no-repeat;">
                    <img src="<?php echo $this->user_model->get_user_thumbnail($this->session->userdata('user_id')); ?>" class="rounded-circle user-bg-img" width="80" height="80" alt="...">
                    <div class="user-name-for-profile">
                        <b class="m-0 p-0"><?php echo $user_details['name']; ?></b>
                        <p class="font-12 m-0 p-0"><b><?php echo $user_details['address']; ?></b></p>
                    </div>
                </div>
                <div class="card-body">
                    <p><?php echo $user_details['about']; ?></p>
                </div>
            </div>

            <div class="card my-5">
                <div class="card-body">
                    <h6 class="p-0 m-0">
                        <?php echo get_phrase('listing_by'); ?> : <a href="javascript:;"><?php echo $user_details['name']; ?></a>
                        <small class="float-right font-12 mt-2"><?php echo get_phrase('total').' '.$user_listings->num_rows().' '.get_phrase('listings');; ?></small>
                    </h6>
                </div>
            </div>

            <div class="row">
                <?php foreach($user_listings->result_array() as $listing): ?>
                    <!-- A Single Listing Starts-->
                    <div class="col-lg-6 col-md-6 listing-div " data-marker-id="<?php echo $listing['code']; ?>" id = "<?php echo $listing['code']; ?>">
                        <div class="strip grid <?php if($listing['is_featured'] == 1) echo 'featured-tag-border'; ?>">
                            <figure>
                                <?php if($listing['is_featured'] == 1){ ?>
                                    <a href="javascript::" class="featured-tag-grid"><?php echo get_phrase('featured'); ?></a>
                                <?php } ?>

                                <a href="<?php echo get_listing_url($listing['id']); ?>"  id = "listing-banner-image-for-<?php echo $listing['code']; ?>"  class="d-block h-100 img" style="background-image:url('<?php echo base_url('uploads/listing_thumbnails/'.$listing['listing_thumbnail']); ?>')">
                                    <div class="read_more"><span><?php echo get_phrase('watch_details'); ?></span></div>
                                </a>
                                <small><?php echo $listing['listing_type'] == "" ? ucfirst(get_phrase('general')) : ucfirst(get_phrase($listing['listing_type'])) ; ?></small>
                            </figure>
                            <div class="wrapper <?php if($listing['is_featured'] == 1) echo 'featured-body'; ?>">
                                <h3 class="ellipsis">
                                    <a href="<?php echo get_listing_url($listing['id']); ?>"><?php echo $listing['name']; ?></a>
                                    <?php $claiming_status = $this->db->get_where('claimed_listing', array('listing_id' => $listing['id']))->row('status'); ?>
                                    <?php if($claiming_status == 1): ?>
                                        <span class="claimed_icon" data-toggle="tooltip" title="<?php echo get_phrase('this_listing_is_verified'); ?>">
                                            <img src="<?php echo base_url('assets/frontend/images/verified.png'); ?>" width="23" />
                                        </span>
                                    <?php endif; ?>
                                </h3>
                                <small>
                                    <?php
                                    $city    = $this->db->get_where('city', array('id' =>  $listing['city_id']))->row_array();
                                    $country = $this->db->get_where('country', array('id' =>  $listing['country_id']))->row_array();
                                    echo $city['name'].', '.$country['name'];
                                    ?>
                                </small>
                                <p class="ellipsis">
                                    <?php echo $listing['description']; ?>
                                </p>
                            </div>
                            <ul class="<?php if($listing['is_featured'] == 1) echo 'featured-footer'; ?> mb-0">

                                <li><span class="<?php echo strtolower(now_open($listing['id'])) == 'closed' ? 'loc_closed' : 'loc_open'; ?>"><?php echo now_open($listing['id']); ?></span></li>
                                <li>
                                    <div class="score">
                                        <span>
                                            <?php
                                            if ($this->frontend_model->get_listing_wise_rating($listing['id']) > 0) {
                                            $quality = $this->frontend_model->get_rating_wise_quality($listing['id']);
                                            echo $quality['quality'];
                                            }else {
                                            echo get_phrase('unreviewed');
                                            }
                                            ?>
                                            <em>
                                                <?php echo count($this->frontend_model->get_listing_wise_review($listing['id'])).' '.get_phrase('reviews'); ?>
                                            </em>
                                        </span>
                                        <strong><?php echo $this->frontend_model->get_listing_wise_rating($listing['id']); ?></strong>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- A Single Listing Ends-->
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6><?php echo get_phrase('author'); ?></h6>
                            <hr class="mx-0 my-3">
                        </div>
                        <div class="col-md-4 text-center">
                            <img src="<?php echo $this->user_model->get_user_thumbnail($user_details['id']); ?>" width="50" class="rounded-circle">
                        </div>
                        <div class="col-md-8">
                            <p class="m-0"><b><?php echo $user_details['name'] ?></b></p>
                            <small class="text-muted"><?php echo $user_details['address'] ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h6><?php echo get_phrase('contact'); ?></h6>
                        </div>
                        <div class="col-md-12">
                            <div class="row mt-2 py-3 border-bottom border-top">
                                <div class="col-md-4 pr-0">
                                    <i class="ti-home text-primary"></i>
                                    <?php echo get_phrase('address'); ?> :
                                </div>
                                <div class="col-md-8">
                                    <a href="javascript:;"><small class=""><?php echo $user_details['address']; ?></small></a>
                                </div>
                            </div>
                            <div class="row py-3 border-bottom">
                                <div class="col-md-4 pr-0">
                                    <i class="ti-mobile text-primary"></i>
                                    <?php echo get_phrase('phone'); ?> :
                                </div>
                                <div class="col-md-8">
                                    <a href="tel:<?= $user_details['phone']; ?>"><small class=""><?php echo $user_details['phone']; ?></small></a>
                                </div>
                            </div>
                            <div class="row py-3 border-bottom">
                                <div class="col-md-4 pr-0">
                                    <i class="ti-email text-primary"></i>
                                    <?php echo get_phrase('mail'); ?> :
                                </div>
                                <div class="col-md-8">
                                    <a href="mailto:<?= $user_details['email']; ?>"><small class=""><?php echo $user_details['email']; ?></small></a>
                                </div>
                            </div>
                            <div class="row py-3 border-bottom">
                                <div class="col-md-4 pr-0">
                                    <i class="ti-email text-primary"></i>
                                    <?php echo get_phrase('website'); ?> :
                                </div>
                                <div class="col-md-8">
                                    <a href="<?= $user_details['website']; ?>" target="_blank" ><small class=""><?php echo $user_details['website']; ?></small></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4 mb-4">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h6><?php echo get_phrase('socials'); ?></h6>
                        </div>
                        <div class="col-md-12">
                            <?php $socials = json_decode($user_details['social']); ?>
                            <div class="row py-3 border-top">
                                <div class="col-md-12 pr-0">
                                    <a target="_blank" href="<?= $socials->facebook; ?>" style="font-size: 25px;"><i class="fab fa-facebook"></i></a>
                                    <a target="_blank" href="<?= $socials->twitter; ?>" style="font-size: 25px; margin-left: 20px; margin-right: 20px;"><i class="fab fa-twitter"></i></a>
                                    <a target="_blank" href="<?= $socials->linkedin; ?>" style="font-size: 25px;"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>