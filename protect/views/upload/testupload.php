<html>
    <head>
        <title>Drag and Drop</title>
        <meta charset="utf-8">
        <style>
            body {
                background: rgba(211,211,100, .5);
                font: 20px Arial;
            }

            .dropzone {
                width: 300px;
                height: 300px;
                border: 2px dashed #aaa;
                color: #aaa;
                line-height: 280px;
                text-align: center;
                position: absolute;
                left: 50%;
                margin-left: -150px;
                top: 50%;
                margin-top: -150px;
            }

            .dropzone.dragover {
                color: green;
                border: 2px dashed #000;
            }
        </style>
    </head>
    <body>
        <p>Загруженные файлы:</p>
        <div id="uploads">
            <ul>

            </ul>
        </div>
        <div class="dropzone" id="dropzone">Перетащите файлы сюда</div>
        <script>
            (function() {
                var dropzone = document.getElementById("dropzone");
                dropzone.ondragover = function() {
                    this.className = 'dropzone dragover';
                    this.innerHTML = 'Отпустите мышку';
                    return false;
                };

                dropzone.ondragleave = function() {
                    this.className = 'dropzone';
                    this.innerHTML = 'Перетащите файлы сюда';
                    return false;
                };

                dropzone.ondrop = function(e) {
                    this.className = 'dropzone';
                    this.innerHTML = 'Перетащите файлы сюда';
                    e.preventDefault();
                    upload(e.dataTransfer.files);

                };
                var displayUploads = function(data) {
                    var uploads = document.getElementById("uploads"),
                            anchor,
                            x;

                    for (x = 0; x < data.length; x++) {
                        anchor = document.createElement('li');
                        anchor.innerHTML = data[x].name;
                        uploads.appendChild(anchor);
                    }
                };
                var upload = function(files) {
                    var formData = new FormData(),
                            xhr = new XMLHttpRequest(),
                            x;

                    for (x = 0; x < files.length; x++) {
                        formData.append('file[]', files[x]);
                    }

                    xhr.onload = function() {
                        var data = JSON.parse(this.responseText);
                        displayUploads(data);
                    };

                    xhr.open('post', '/upload/proccesstestupload');
                    xhr.send(formData);
                };
            })();
        </script>
    </body>
</html>