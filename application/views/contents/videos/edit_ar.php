<style>
  .progress-container {
    display: none;
    position: relative;
    width: 100%;
    max-width: 400px;
    border: 1px solid #ddd;
    padding: 1px;
    border-radius: 3px;
  }

  .progress-bar {
    background-color: #B4F5B4;
    width: 0%;
    height: 20px;
    border-radius: 3px;
  }

  .percent {
    position: absolute;
    display: inline-block;
    top: 3px;
    left: 48%;
  }

  .preview {
    display: none;
  }
</style>

<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
$parentro=isset($val['id']) ? "disabled='disabled'":"";
?>

<div class="row">
  <div class="col-lg-12 col-ml-12">
    <div class="row">
      <div class="col-12 mt-5">
        <div class="card">
          <div class="card-body">

            <div class="box-content">
              <form method="post" id="formupload" action="<?php echo base_url($this->utama)?>/submit_ar">
                <?php echo form_hidden('id', isset($val['id']) ? $val['id'] : '')?>
                <?php echo form_hidden('lang', isset($lang) ? $lang : '')?>

                <div class="form-group">
                  <?php $nm_f="video_".$lang;?>
                  <label for="parents">Video <?php echo strtoupper($lang)?></label>
                  <?php echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : '', " data-rel='chosen' class='form-control' id='$nm_f' readonly='readonly'")?>
                </div>

                <div class="form-group">
                  <?php $nm_f="name_".$lang;?>
                  <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                  <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required readonly='readonly'>
                </div>

                <div class="form-group">
                  <?php 
                    $nm_f = "repository";
                    $default_value = (isset($val[$nm_f]) && !empty($val[$nm_f])) ? $val[$nm_f] : 'Data Belum Tersedia';
                  ?>
                  <label for="<?php echo $nm_f ?>">Repository AR</label>
                  <?php echo form_textarea($nm_f, $default_value, 'class="form-control" style="height:100px;" id="' . $nm_f . '" required') ?>
                </div>

                <div class="form-group">
                  <?php 
                    $nm_f = "project";
                    $default_value = (isset($val[$nm_f]) && !empty($val[$nm_f])) ? $val[$nm_f] : 'Data Belum Tersedia';
                  ?>
                  <label for="<?php echo $nm_f ?>">Project AR</label>
                  <?php echo form_textarea($nm_f, $default_value, 'class="form-control" style="height:100px;" id="' . $nm_f . '" required') ?>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn pull-right">Submit</button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
