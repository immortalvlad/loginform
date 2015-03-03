<form action="/upload/upload" method="post" enctype="multipart/form-data" id="upload" class="upload">
    <fieldset>
        <legend>Uplad files</legend>
        <input type="file" name="file[]"  id="file" required multiple>
        <input type="submit" name="submit" vlaue="Upload" id="submit">
    </fieldset>
    <div class="bar">
        <span class="bar-fill" id='pb'><span class="bar-fill-text" id="pt">40%</span> </span>
    </div>

    <div class="uploads" id="uploads">
        Uploaded file links will appear here.
        <a href="#">file1</a>
        <a href="#">file2</a>
        <p>These files didn't upload:</p>
        <span>file1</span>
        <span>file2</span>
    </div>
    <link rel="stylesheet" href="/protect/theme/css/style.css"/>
    <script src="/protect/theme/js/upload.js"></script>
    <script>
        document.getElementById('submit').addEventListener('click', function(e) {
            e.preventDefault();
            var f = document.getElementById('file'),
                    pb = document.getElementById('pb'),
                    pt = document.getElementById('pt')
            app.uploader({
                files: f,
                progressBar: pb,
                progressText: pt,
                processor: 'upload/upload',
                finished: function(data) {
                    console.log(data);
                    var uploads = document.getElementById('uploads'),
                            succeeded = document.createElement('div'),
                            failed = document.createElement('div'),
                            anchor, span, x;
                    if (data.failed.length) {
                        failed.innerHTML = '<p>Unfortunately, the following failed:</p>'
                    }
                    uploads.innerText = '';

                    for (x = 0; x < data.succeeded.length; x++) {
                        anchor = document.createElement('a');
                        anchor.href = 'uploads/' + data.succeeded[x].file;
                        anchor.innerText = data.succeeded[x].name;
                        anchor.target = '_blank';
//                        console.log(anchor);
                        succeeded.appendChild(anchor);
                    }
                    for (x = 0; x < data.failed.length; x++) {
                        span = document.createElement('span');
                        span.innerText = data.failed[x].name;
                        failed.appendChild(span);
                    }
                    uploads.appendChild(succeeded);
                    uploads.appendChild(failed);
                },
                error: function() {
                    console.log('Not working');
                }
            });
        });
    </script>
</form>

