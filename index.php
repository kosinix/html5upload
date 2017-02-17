<?php
session_start();
require_once 'restrict.php';

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width">
    <title>HTML5 Uploader</title>
    <script src="js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="logout.php">Logout</a>
<form id="frmInput" action="" method="post">
    <input type="file" id="fileUploader" multiple accept="*">
    <div id="droppable">
        <p>Drop it like its hot</p>
    </div>
    <ul id="files" class="files">
    </ul>
</form>
<script>
    jQuery(document).ready(function($){
        $('#frmInput').on('change', '#fileUploader', function(e){
            handleFiles(this.files)
        });

        $('#droppable')
                .on('dragenter', function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    $(this).addClass('over');
                })
                .on('dragover', function(e){
                    e.stopPropagation();
                    e.preventDefault();
                })
                .on('dragleave', function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    $(this).removeClass('over');
                })
                .on('drop', function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    $(this).removeClass('over');
                   handleFiles(e.originalEvent.dataTransfer.files);
                })
                .on('click', function(){
                    $('#fileUploader').trigger('click');
                });
    });
    function handleFiles(files){
        var x,
            inner = '';

        for(x=0; x<files.length; x++){
            inner += '<li>'+ files[x].name +' <span>0%</span></li>';
        }
        $('#files').html(inner);

        for(x=0; x<files.length; x++){
            sendFile(files[x], x);
        }

    }

    function sendFile(file, index) {
        var uri = "upload.php";
        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        formData.append('myFile', file);

        xhr.open("POST", uri, true);

        // Request starts
        xhr.upload.onloadstart = function(event) {
            $('#files').children().eq(index).find('span').html('Uploading...');
        };
        // Sending and loading data
        xhr.upload.onprogress = function (event) {
            if (event.lengthComputable) {
                var complete = (event.loaded / event.total * 100 | 0);
                $('#files').children().eq(index).find('span').html(complete+'%');
            }
        };
        // Error
        xhr.upload.onerror = function (event) {
            alert('Error uploading file '+index);
        };
        // Success and server closed conn
        xhr.onload = function() {
            $('#files').children().eq(index).find('span').html('100%');
        };

        // Initiate a multipart/form-data upload
        xhr.send(formData);
    }
</script>
</body>
</html>