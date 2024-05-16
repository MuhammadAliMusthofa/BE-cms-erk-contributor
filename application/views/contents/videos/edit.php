<style>
.progress 
{
  display:none; 
  position:relative; 
  width:400px; 
  border: 1px solid #ddd; 
  padding: 1px; 
  border-radius: 3px; 
}
.bar 
{ 
  background-color: #B4F5B4; 
  width:0%; 
  height:20px; 
  border-radius: 3px; 
}
.percent 
{ 
  position:absolute; 
  display:inline-block; 
  top:3px; 
  left:48%; 
}
</style>
<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
$parentro=isset($val['id']) ? "disabled='disabled'":"";
?>

<?php if($this->session->flashdata('message')){?>
<div class="row">
	<div class="col-md-12">
      <div class="card">
       <div class="card-body">
        

    	<div class="box-content">
  			<div class="alert alert-<?php echo ($this->session->flashdata('err_code')=='0')? 'success':'danger'?>" role="alert">
  			<?php echo $this->session->flashdata('message')?>
		</div>
	</div>
	</div>
	</div>
</div>
  			</div><?php }?>
<div class="row">
 <div class="col-lg-12 col-ml-12">
   <div class="row">
                            <!-- Textual inputs start -->
     <div class="col-12 mt-5">
      <div class="card">
       <div class="card-body">
        

    	<div class="box-content">
       <form method="post" id="formupload" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit">
            <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
            <?php echo form_hidden('lang',isset($lang) ? $lang : '')?>

            <!-- <div class="form-group">
                <label>ID Video</label>
                <input type="text" value="<?php echo isset($val['id']) ? $val['id'] : ''; ?>" class="form-control" readonly>
            </div> -->

           
    		   <div class="form-group">
            			<?php $nm_f="video_".$lang;?>
                        <label for="parents"><?php echo strtoupper($lang)?> Video Brigthcove</label>
             			<?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='form-control' id='$nm_f' readonly='readonly'")?>
             </div>
            <div class="form-group">
            
            <?php $nm_f="name_".$lang;?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required  readonly='readonly'>
                        <?php echo form_input('filename_'.$lang,isset($val['filename']) ? $val['filename'] : '','style="display:none" id="filename"')?>
    		
             </div>
            <div class="form-group">
            <?php $nm_f="autocaption";?>
                        <label for="<?php echo $nm_f?>">Auto Caption?</label>
                        <?php echo form_checkbox($nm_f,1,(isset($val[$nm_f]) && $val[$nm_f]==1 ? TRUE : FALSE),'class="" id="'.$nm_f.'" ')?>
    		
             </div>
            <div class="form-group">
            
            <?php $nm_f="filez";?>
                        <label for="<?php echo $nm_f?>">Video File (format MP4, Max 4gb)</label>
                        <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" accept="video/mp4,video/x-m4v,video/*" class="form-control" required>
    		
             </div>
            <div class="form-group" style="display:none">
            <?php $nm_f="posterz";?>
                        <label for="<?php echo $nm_f?>">Poster File (format JPG, 1400px x 1400px)</label>
                        <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" required>
    		
             </div>
            <div class="form-group" style="display:none">
            <?php $nm_f="thumbnailz";?>
                        <label for="<?php echo $nm_f?>">Thumbnail File (format JPG, 160px x 90px)</label>
                        <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" required>
    		
             </div>
             <progress id="progressBar" value="0" max="100" style="width:100%; display:none;"></progress>
              <h3 id="status"></h3>
              <p id="loaded_n_total"></p>
            <div class='progress' id="progress_div">
               <div class='bar' id='bar1'></div>
               <div class='percent' id='percent1'>0%</div>
            </div>
            <!--div class="form-group">
            
            <?php $nm_f="label";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" readonly='readonly'>
    		
             </div-->
    		
    		<div class="form-group">
            <button type="button" class="btn pull-right" onclick='uploadFileVideo();'>Submit</button>
            </form>
             </div>
    	</div>
    	
    </div>
    </div>
</div>
   </div>
 </div>
</div>




<script>
function _(el) {
  return document.getElementById(el);
}

function uploadFileVideo() {
  $('#progressBar').show();
  var file = _("filez").files[0];
  //let myForm = document.getElementById('formupload');
  //var formData = new FormData(myForm);
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData();
  formdata.append("filez", file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "<?php echo base_url()?>videos/upload_video/<?php echo $lang?>"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
  //use file_upload_parser.php from above url
  ajax.send(formdata);
}

function progressHandler(event) {
  _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
  //_("status").innerHTML = event.target.responseText;
  //_("progressBar").value = 0; //wil clear progress bar after successful upload
  //alert(event.target.responseText);
  //window.location = '<?php echo base_url()?>/videos';
  let balik=JSON.parse(event.target.responseText);
  if(balik.status_job=='done'){
    $("#filename").val(balik.file_name);
    $('#filez').attr('disabled', 'disabled');
    $("#formupload").submit(
      //function(){
     // 
      //return true;
      //}
    );
  }else{
    alert(balik.error);
  }
  $('#progressBar').hide();
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}

</script>