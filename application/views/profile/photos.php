<div class="photo_upload_box">
    <h2>Einschulungsfoto</h2>
    <img id="userphoto1" src="<?php echo $this->config->base_url('assets/img/user_photos/' .
        ((!is_null($user['photo1_id']))? $user['photo1_id'] : 'placeholder.png')
        ); ?>" alt="User Image 1" height="514px" width="400px"/>

    <ul id="filelist1"></ul>
    <div id="container">
        <a id="browse1" href="javascript:;">Foto 1 ausw&auml;hlen</a>
        <a id="start-upload1" href="javascript:;">hochladen</a>
    </div>
</div>

<hr />

<div class="photo_upload_box">
    <h2>Aktuelles Foto</h2>
    <img id="userphoto2" src="<?php echo $this->config->base_url('assets/img/user_photos/' .
    ((!is_null($user['photo2_id']))? $user['photo2_id'] : 'placeholder.png')
    ); ?>" alt="User Image 2" height="514px" width="400px"/>

    <ul id="filelist2"></ul>
    <div id="container">
        <a id="browse2" href="javascript:;">Foto 2 ausw&auml;hlen</a>
        <a id="start-upload2" href="javascript:;">hochladen</a>
    </div>
</div>

<pre id="console"></pre>
 
<script src="<?php echo $this->config->base_url('assets/js/plupload.full.min.js'); ?>"></script>
<script type="text/javascript">
function setup_uploader(uploader, id){
    uploader.init();
    uploader.bind('FilesAdded', function(up, files) {
      var html = '';
      plupload.each(files, function(file) {
        html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
      });
      document.getElementById('filelist' + id).innerHTML += html;
    });
    uploader.bind('UploadProgress', function(up, file) {
      document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
    });
    document.getElementById('start-upload' + id).onclick = function() {
      uploader.start();
    };
    uploader.bind('Error', function(up, err) {
      document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
    });
    uploader.bind('FileUploaded', function(up, err, response) {
        img_url = response.response;
        document.getElementById('userphoto' + id).src = img_url;
    });
}

var uploader1 = new plupload.Uploader({
  browse_button: 'browse1', // this can be an id of a DOM element or the DOM element itself
  url: '<?php echo $this->config->site_url('profile/upload_photo/1'); ?>',
  multi_selection: false,
  resize: {
    width: 400,
    height: 514 
  },
  filters: {
    mime_types : [
      { title : "Image files", extensions : "jpg" }
    ],
    max_file_size: "5mb",
    prevent_duplicates: true
  }
});
setup_uploader(uploader1, 1);


var uploader2 = new plupload.Uploader({
  browse_button: 'browse2', // this can be an id of a DOM element or the DOM element itself
  url: '<?php echo $this->config->site_url('profile/upload_photo/2'); ?>',
  multi_selection: false,
  resize: {
    width: 400,
    height: 514,
    crop: true
  },
  filters: {
    mime_types : [
      { title : "Image files", extensions : "jpg" }
    ],
    max_file_size: "5mb",
    prevent_duplicates: true
  }
});
setup_uploader(uploader2, 2);
</script>
