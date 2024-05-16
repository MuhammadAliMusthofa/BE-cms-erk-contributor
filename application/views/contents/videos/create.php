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
<?php
error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){   
    $val = $list->row_array();
}
$parentro = isset($val['id']) ? "disabled='disabled'" : "";
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
</style>
<div class="row">
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="create-tab" data-toggle="tab" href="#create" role="tab" aria-controls="create" aria-selected="true">Edit Metadata</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="caption-tab" data-toggle="tab" href="#caption" role="tab" aria-controls="caption" aria-selected="false">Caption</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="thumbnail-tab" data-toggle="tab" href="#thumbnail" role="tab" aria-controls="thumbnail" aria-selected="false">Thumbnail</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cover-tab" data-toggle="tab" href="#cover" role="tab" aria-controls="cover" aria-selected="false">Cover</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">Video</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="worksheet-tab" data-toggle="tab" href="#worksheet" role="tab" aria-controls="worksheet" aria-selected="false">Worksheet</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="create" role="tabpanel" aria-labelledby="create-tab">
                                <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/create_submit">
                                    <?php echo form_hidden('id', isset($val['id']) ? $val['id'] : '') ?>
                                    <?php echo form_hidden('video_id', isset($val['video_id']) ? $val['video_id'] : '') ?>
                                    <?php echo form_hidden('video_en', isset($val['video_en']) ? $val['video_en'] : '') ?>
                                    <!-- name  -->
                                    <div class="form-group">
                                        <?php $nm_f = "name_id"; ?>
                                        <label for="<?php echo $nm_f ?>">Video Name</label>
                                        <input type="text" name="<?php echo $nm_f ?>" id="<?php echo $nm_f ?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" required>
                                    </div>
                                    <!-- desk  -->
                                    <div class="form-group">
                                        <?php $nm_f = "description_id"; ?>
                                        <label for="<?php echo $nm_f ?>">Video Description</label>
                                        <?php echo form_textarea($nm_f, (isset($val[$nm_f]) ? $val[$nm_f] : ''), 'class="form-control" onkeyup="countdesc(this)" rows="2" maxlength="200" style="height:100%;" id="' . $nm_f . '" required') ?>
                                        Character: <span id="char_count">0/200</span>
                                    </div>
                                    
                                    <div class="form-group" style="display:none">
                                        <?php $nm_f = "name_en"; ?>
                                        <label for="<?php echo $nm_f ?>">Video <?php echo ucfirst($nm_f) ?></label>
                                        <input type="text" name="<?php echo $nm_f ?>" id="<?php echo $nm_f ?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
                                    </div>

                                    <div class="form-group" style="display:none">
                                        <?php $nm_f="description_en";?>
                                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                                        <?php echo form_textarea($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" rows="2" style="height:100%;" id="'.$nm_f.'" ')?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <?php $nm_f = "labels"; ?>
                                        <label for="<?php echo $nm_f ?>">Video <?php echo ucfirst($nm_f) ?></label>
                                        <?php echo form_dropdown($nm_f . '[]', $opt_labels, (isset($labels) ? $labels : ''), 'class="form-control select2" id="' . $nm_f . '" multiple') ?>
                                    </div>

                                    <div class="form-group">
                                        <?php $nm_f = "jenjang"; ?>
                                        <label for="<?php echo $nm_f; ?>">Video <?php echo ucfirst($nm_f); ?></label>
                                        <?php echo form_dropdown($nm_f . '[]', $opt_jenjang, array(), 'class="form-control select2" id="' . $nm_f . '" multiple required'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php $nm_f = "topik"; ?>
                                        <label for="<?php echo $nm_f; ?>">Video <?php echo ucfirst($nm_f); ?></label>
                                        <?php echo form_dropdown($nm_f . '[]', $opt_topik, array(), 'class="form-control select2" id="' . $nm_f . '" multiple required'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php $nm_f = "konten"; ?>
                                        <label for="<?php echo $nm_f; ?>">Video <?php echo ucfirst($nm_f); ?></label>
                                        <?php echo form_dropdown($nm_f . '[]', $opt_konten, array(), 'class="form-control select2" id="' . $nm_f . '" multiple required'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php $nm_f="tags";?>
                                        <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?></label>
                                        <?php echo form_dropdown($nm_f.'[]',$opt_tags,(isset($tags) ? $tags : ''),'class="form-control select2" id="'.$nm_f.'" multiple')?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="row" style="text-align: center;">
                                            <div class="col-12 col-md-4">
                                                <?php $nm_f = "free"; ?>
                                                <label for="<?php echo $nm_f ?>">Video <?php echo ucfirst($nm_f) ?> ?</label>
                                                <?php echo form_checkbox($nm_f, 1, (isset($val[$nm_f]) && $val[$nm_f] == 1 ? TRUE : FALSE), 'class="" id="' . $nm_f . '" ') ?>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <?php $nm_f="recommended";?>
                                                <label for="<?php echo $nm_f?>">Video <?php echo ucfirst($nm_f)?> ?</label>
                                                <?php echo form_checkbox($nm_f,1,(isset($val[$nm_f]) && $val[$nm_f]==1 ? TRUE : FALSE),'class="" id="'.$nm_f.'" ')?>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <?php $nm_f="show_homepage";?>
                                                <label for="<?php echo $nm_f?>">Show on homepage ?</label>
                                                <?php echo form_checkbox($nm_f,1,(isset($val[$nm_f]) && $val[$nm_f]==1 ? TRUE : FALSE),'class="" id="'.$nm_f.'" ')?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn pull-right">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="caption" role="tabpanel" aria-labelledby="caption-tab">
                                <form method="post" id="formuploadCaption" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit_caption">
                                    <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
                                    <?php //echo form_hidden('lang',isset($lang) ? $lang : '')?>
                                
                                    
                                    <div class="form-group">
                                                <?php $nm_f="video_id";?>
                                                <label for="parents">Video</label>
                                                <?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='form-control' id='$nm_f' readonly='readonly'")?>
                                    </div>
                                    <div class="form-group">
                                    
                                    <?php $nm_f="name_id";?>
                                                <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                                                <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required  readonly='readonly'>
                                                <?php echo form_input('filename',isset($val['filename']) ? $val['filename'] : '','style="display:none" id="filename"')?>
                                    
                                    </div>
                                    <div class="form-group">
                                    
                                    <?php $nm_f="lang";?>
                                                <label for="<?php echo $nm_f?>">Bahasa</label>
                                                <?php echo form_dropdown('lang',array(''=>'-Bahasa-','id'=>'Indonesia','en'=>'English'),isset($val['lang']) ? $val['lang'] : '','class="form-control" id="lang" required')?>
                                    
                                    </div>
                                    <div class="form-group">
                                    
                                    <?php $nm_f="filez";?>
                                                <label for="<?php echo $nm_f?>">Caption File (format VTT)</label>
                                                <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" required accept=".vtt">
                                    
                                    </div>
                                    <progress id="progressBar" value="0" max="100" style="width:100%; display:none;"></progress>
                                    <h3 id="status"></h3>
                                    <p id="loaded_n_total"></p>
                                    <div class='progress' id="progress_div">
                                    <div class='bar' id='bar1'></div>
                                    <div class='percent' id='percent1'>0%</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="button" class="btn pull-right" onclick='uploadFileCaption();'>Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="thumbnail" role="tabpanel" aria-labelledby="thumbnail-tab">
                                <form method="post" id="formupload" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit_thumbnail">
                                    <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
                                    <?php echo form_hidden('lang',isset($lang) ? $lang : '')?>
    		                        <div class="form-group">
                                        <?php $nm_f="video_id"?>
                                        <label for="parents">Video <?php echo strtoupper($lang)?></label>
                                        <?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='form-control' id='$nm_f' readonly='readonly'")?>
                                    </div>
                                    <div class="form-group">
                                        <?php $nm_f="name_id"?>
                                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required  readonly='readonly'>
                                        <?php echo form_input('thumbnail_'.$lang,isset($val['thumbnail_'.$lang]) ? $val['thumbnail_'.$lang] : '','style="display:none" id="filename"')?>
    	                            </div>
                                    <div class="form-group">
                                        <?php $nm_f="filez";?>
                                        <label for="<?php echo $nm_f?>">Thumbnail File (format JPG, 364px x 165px)</label>
                                        <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" required accept="image/jpg, image/jpeg"  onchange="showPreview(event);">
                                    </div>
                                    <div class="preview" style="display:none">
                                        Preview Image
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img id="file-ip-1-preview" style="max-width:100%">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(!empty($val['thumbnail_id'])){?>
                                    <div class="form-group">
                                        <label for="<?php echo $nm_f?>">Current Thumbnail : </label>
                                        <div class="col-md-6"> <img src="<?php echo base_url().'assets/upload_thumbnail/'.$val['thumbnail_id']?>"/></div>
    		                        </div>
                                    <?php }?>
                                    <div class="form-group" style="display:none">
                                        <?php $nm_f="posterz";?>
                                        <label for="<?php echo $nm_f?>">Poster File (format JPG, 364px x 165px)</label>
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
    		                		<div class="form-group">
                                        <button type="button" class="btn pull-right" onclick='uploadFile();'>Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="cover" role="tabpanel" aria-labelledby="cover-tab">
                                <form method="post" id="formupload" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit_poster">
                                    <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
                                    <?php echo form_hidden('lang',isset($lang) ? $lang : '')?>
    		                        <div class="form-group">
                                        <?php $nm_f="video_id"?>
                                        <label for="parents">Video <?php echo strtoupper($lang)?></label>
                                        <?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='form-control' id='$nm_f' readonly='readonly'")?>                      
                                    </div>
                                    <div class="form-group"> 
                                        <?php $nm_f="name_id"?>
                                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required  readonly='readonly'>
                                        <?php echo form_input('poster_'.$lang,isset($val['filename']) ? $val['filename'] : '','style="display:none" id="filename"')?>
                                    </div>
                                    <div class="form-group">            
                                        <?php $nm_f="filez";?>
                                            <label for="<?php echo $nm_f?>">Poster File (format JPG, 1488px x 536px)</label>
                                            <input type="file" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" required accept="image/jpg, image/jpeg"  onchange="showPreview(event);">
                                    </div>
                                    <div class="preview" style="display:none">
                                        Preview Image
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img id="file-ip-1-preview" style="max-width:100%">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(!empty($val['poster_id'])){?>
                                    <div class="form-group">
                                        <label for="<?php echo $nm_f?>">Current Poster : </label>
                                        <div class="col-md-6"> <img src="<?php echo base_url().'assets/upload_poster/'.$val['poster_id']?>"/></div>
    		                        </div>
                                    <?php }?>
                                    <div class="form-group" style="display:none">
                                        <?php $nm_f="posterz";?>
                                        <label for="<?php echo $nm_f?>">Poster File (format JPG, 1488px x 536px)</label>
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
    		                        <div class="form-group">
                                        <button type="button" class="btn pull-right" onclick='uploadFile();'>Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
                                <form method="post" id="formupload" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit">
                                    <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
                                    <?php echo form_hidden('lang',isset($lang) ? $lang : '')?>
                        		    <div class="form-group">
                                        <?php $nm_f="video_id"?>
                                        <label for="parents"><?php echo strtoupper($lang)?> Video Brigthcove</label>
                                        <?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='form-control' id='$nm_f' readonly='readonly'")?>
                                    </div>
                                    <div class="form-group">
                                        <?php $nm_f="name_id"?>
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

                                    <?php if (!empty($val['filename_id'])) { ?>
                                        <div class="form-group">
                                            <label for="<?php echo $nm_f ?>">Preview Videos : <?php echo $val['filename_id'] ?></label>
                                            <div class="col-md-6">
                                                <video width="100%" height="100%" controls>
                                                    <source src="<?php echo ($val['filename_id']) ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    <?php } ?>

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
    		                        <div class="form-group">
                                        <button type="button" class="btn pull-right" onclick='uploadFileVideo();'>Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="worksheet" role="tabpanel" aria-labelledby="worksheet-tab">
                                <form method="post" id="formuploadWorksheet" enctype="multipart/form-data" action="<?php echo base_url('videos/submit_worksheet'); ?>">
                                    <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
                                    <?php //echo form_hidden('lang',isset($lang) ? $lang : '')?>
                                
                                    <div class="form-group">
                                                <?php $nm_f="video_id";?>
                                                <label for="parents"><?php echo strtoupper($lang)?> Video Brigthcove</label>
                                                <?php echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='form-control' id='$nm_f' readonly='readonly'")?>
                                    </div>
                                    <div class="form-group">
                                    <?php $nm_f="name_id";?>
                                                <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                                                <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" onkeyup="generatelabel(this.value)" required  readonly='readonly'>
                                                <?php echo form_input('filename_id',isset($val['filename']) ? $val['filename'] : '','style="display:none" id="filename"')?>
                                    </div>
                                    <div class="form-group" style="display:none">
                                    <?php $nm_f="autocaption";?>
                                                <label for="<?php echo $nm_f?>">Auto Caption?</label>
                                                <?php echo form_checkbox($nm_f,1,(isset($val[$nm_f]) && $val[$nm_f]==1 ? TRUE : FALSE),'class="" id="'.$nm_f.'" ')?>
                                    </div>
                                    <div class="form-group">
                                        <?php $nm_f = "filez"; ?>
                                        <label for="<?php echo $nm_f; ?>">Worksheet PDF</label>
                                        <input type="file" name="<?php echo $nm_f; ?>" id="<?php echo $nm_f; ?>" accept="application/pdf" class="form-control" required>
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
                                    
                                    <div class="form-group">
                                        <button type="button" class="btn pull-right" onclick="uploadFile('worksheet');">Submit</button>
                                    </div>
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
    $(document).ready(function(e) {
        $('.select2').select2();
        countdesc();
    });

    function countdesc() {
        var v = $('#description_id').val().length;
        let numOfEnteredChars = v;
        $('#char_count').text(numOfEnteredChars + '/200');
        if (numOfEnteredChars == 200) {
            $('#char_count').css("color", "red");
        } else {
            $('#char_count').css("color", "black");
        }
    }
</script>
<script>
function _(el) {
  return document.getElementById(el);
}

function uploadFile(tab) {
  $('#progressBar').show();
  var file = _("filez").files[0];
  var formdata = new FormData();
  formdata.append("filez", file);

  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", function(event) {
    progressHandler(event, tab);
  }, false);
  ajax.addEventListener("load", function(event) {
    completeHandler(event, tab);
  }, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);

  var url = (tab === 'caption') ? "<?php echo base_url('videos/upload_caption/' . $lang); ?>" : "<?php echo base_url('videos/upload_worksheet/' . $lang); ?>";
  ajax.open("POST", url);
  ajax.send(formdata);
}

function progressHandler(event, tab) {
  _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event, tab) {
  let balik = JSON.parse(event.target.responseText);
  if (balik.status_job === 'done') {
    $("#filename").val(balik.file_name);
    $('#' + tab + '_filez').attr('disabled', 'disabled');
    $("#formupload" + tab.charAt(0).toUpperCase() + tab.slice(1)).submit();
  } else {
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
