<script type="text/javascript">

function largeModal(url, header)
{
  jQuery('#large-modal').modal('show', {backdrop: 'true'});
  // SHOW AJAX RESPONSE ON REQUEST SUCCESS
  $.ajax({
    url: url,
    success: function(response)
    {
      jQuery('#large-modal .modal-body').html(response);
      jQuery('#large-modal .modal-title').html(header);
    }
  });
}

function showAjaxModal(url)
{
    // SHOWING AJAX PRELOADER IMAGE
    jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');

    jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url();?>assets/images/preloader.gif" /></div>');
    // LOADING THE AJAX MODAL
    jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
    // Scroll to top
    window.scrollTo(0, 0);
    // SHOW AJAX RESPONSE ON REQUEST SUCCESS
    $.ajax({
        url: url,
        success: function(response)
        {
            jQuery('#modal_ajax .modal-body').html(response);
        }
    });
}
</script>

<!-- (Ajax Modal)-->
<div class="modal fade" id="modal_ajax">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $website_title;?></h4>
            </div>

            <div class="modal-body" style="overflow:auto;">



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
function confirm_modal(delete_url, modal_type)
{
    // Scroll to top
    window.scrollTo(0, 0);
    if (modal_type === 'generic_confirmation') {
        jQuery('#modal-generic_confirmation').modal('show', {backdrop: 'static'});
        document.getElementById('update_link').setAttribute('href' , delete_url);
    }
    else{
        jQuery('#modal-4').modal('show', {backdrop: 'static'});
        document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
}
</script>

<!-- (Normal Modal)-->
<div class="modal fade" id="modal-4">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;"><?php echo get_phrase('are_you_sure_to_delete_this_information'); ?> ?</h4>
            </div>


            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#" class="btn btn-danger" id="delete_link"><?php echo get_phrase('delete');?></a>
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel');?></button>
            </div>
        </div>
    </div>
</div>

<!-- (generic_confirmation Modal)-->
<div class="modal fade" id="modal-generic_confirmation">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;"><?php echo get_phrase('are_you_sure_to_update_this_information'); ?> ?</h4>
            </div>


            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#" class="btn btn-danger" id="update_link"><?php echo get_phrase('yes');?></a>
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('no');?></button>
            </div>
        </div>
    </div>
</div>

<!--  Large Modal -->
<div class="modal fade" id="large-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-print-none">
        <h4 class="modal-title" id="myLargeModalLabel"></h4>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
