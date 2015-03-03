<html>
    <head>
        <title>Drag and Drop</title>
        <meta charset="utf-8">
        <style>
            body {
                font: 20px Arial;
            }

            #dropzone {
                display: table;
                width: 300px;
                height: 300px;
                border: 4px dashed #aaa;
                color: #aaa;
                line-height: 280px;
                text-align: center; 
                vertical-align: middle;
                text-decoration: none;
            }
            #dropzone:hover{
                cursor: pointer;
                border: 4px dashed rgb(55, 118, 189);
                color: rgb(68, 68, 68);
            }
            #dropzone span{
                vertical-align: middle;
                display: table-cell;
            }
            #dropzone.dragover {
                color: green;
                border: 2px dashed #000;              

            }
            .thumb {
                max-height: 200px;
                border: 1px solid #000;
                margin: 10px 5px 0 0;
            }
            #dropzone.dragover {
                color: green;
                border: 4px dashed #000;
            }
            /*input[type="file"]{
                position: absolute;
                text-indent: 999999999;
                 background-color: red; 
                width: 300px;
                height: 300px;
                border: none;
                background: none;
            }*/
        </style>
        <script src="/protect/theme/js/testupload.js"></script>

    </head>
    <body>
        <p>Загруженные файлы:</p>
        <div id="uploads">
            <ul>

            </ul>
        </div>
        <form action="/upload/proccesstestupload2/" method="post" enctype="multipart/form-data" id="upload" class="upload">
            <input type="file" id="files" name="files[]" multiple />
            <a id="dropzone">Drop files here</a>
            <output id="list"></output>
        </form>
        <!--        <a href="#" class="dropzone" id="dropzone">Перетащите файлы сюда</a>-->
        <script>
// Check for the various File API support.
            if (window.File && window.FileReader && window.FileList && window.Blob) {

                fileUploader({
                    'dropZoneId': 'dropzone',
                    'InputfilesId': 'files'
                });
                fileUploader.upload();
            } else {
                alert('The File APIs are not fully supported in this browser.');
            }

        </script>
    </body>
</html>