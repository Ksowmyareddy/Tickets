<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#eef5ff;
            color:#123b6d;
            padding:30px 20px;
        }

        .page-wrap{
            max-width:1050px;
            margin:0 auto;
        }

        .form-box{
            background:#ffffff;
            border-radius:10px;
            padding:28px 26px;
            margin-bottom:18px;
            box-shadow:0 4px 14px rgba(13,110,253,0.12);
            border:1px solid #cfe2ff;
        }

        .section-title{
            font-size:16px;
            font-weight:700;
            color:#0d6efd;
            margin-bottom:24px;
        }

        .form-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:28px 22px;
        }

        .form-group{
            display:flex;
            flex-direction:column;
        }

        .full-width{
            grid-column:1 / 3;
        }

        label{
            font-size:13px;
            color:#0f3d7a;
            margin-bottom:10px;
            font-weight:600;
        }

        label span{
            color:#ff5c5c;
        }

        input[type="text"],
        input[type="datetime-local"],
        textarea,
        select{
            width:100%;
            background:#fff;
            border:none;
            border-bottom:2px solid #bfd7ff;
            color:#123b6d;
            font-size:14px;
            padding:8px 2px 10px 2px;
            outline:none;
        }

        input[type="text"]:focus,
        input[type="datetime-local"]:focus,
        textarea:focus,
        select:focus{
            border-bottom:2px solid #0d6efd;
        }

        textarea{
            min-height:110px;
            resize:vertical;
            line-height:1.6;
        }

        select{
            cursor:pointer;
        }

        option{
            color:#000;
        }

        .file-input{
            width:100%;
            background:#f6faff;
            border:1px solid #bfd7ff !important;
            border-radius:6px;
            color:#123b6d;
            padding:8px !important;
        }

        .btn-row{
            display:flex;
            gap:10px;
            margin-top:12px;
            flex-wrap:wrap;
        }

        .btn{
            border:none;
            border-radius:6px;
            padding:10px 18px;
            font-size:13px;
            font-weight:600;
            cursor:pointer;
            text-decoration:none;
            display:inline-block;
        }

        .submit-btn{
            background:#0d6efd;
            color:#fff;
        }

        .submit-btn:hover{
            background:#0b5ed7;
        }

        .cancel-btn{
            background:#6c8ebf;
            color:#fff;
        }

        .cancel-btn:hover{
            background:#5c7dab;
        }

        .help-text{
            font-size:12px;
            color:#6b89b0;
            margin-top:8px;
            line-height:1.5;
        }

        .desc-loader{
            display:none;
            margin-top:8px;
            font-size:12px;
            color:#0d6efd;
            font-weight:600;
        }

        .attachment-preview-wrap{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
            margin-top:10px;
        }

        .attachment-card{
            position:relative;
            width:110px;
            min-height:110px;
            background:#f8fbff;
            border:1px solid #cfe2ff;
            border-radius:10px;
            padding:8px;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            overflow:hidden;
        }

        .attachment-card img{
            width:100%;
            height:65px;
            object-fit:cover;
            border-radius:6px;
            margin-bottom:6px;
        }

        .attachment-file-icon{
            font-size:28px;
            color:#0d6efd;
            margin-bottom:6px;
        }

        .attachment-name{
            font-size:10px;
            color:#133b6b;
            text-align:center;
            word-break:break-word;
            line-height:1.3;
            max-height:28px;
            overflow:hidden;
        }

        .remove-file-btn{
            position:absolute;
            top:4px;
            right:4px;
            width:20px;
            height:20px;
            border:none;
            border-radius:50%;
            background:#dc3545;
            color:#fff;
            font-size:12px;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            line-height:1;
        }

        .remove-file-btn:hover{
            background:#bb2d3b;
        }

        .empty-preview{
            font-size:11px;
            color:#7c95b2;
            margin-top:8px;
        }

        @media (max-width:768px){
            .form-grid{
                grid-template-columns:1fr;
            }

            .full-width{
                grid-column:auto;
            }

            .form-box{
                padding:22px 18px;
            }
        }
    </style>
</head>
<body>

<div class="page-wrap">

    <form method="post" action="<?= base_url('tickets/store'); ?>" enctype="multipart/form-data">

        <div class="form-box">
            <div class="section-title">Ticket Information</div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Contact Name <span>*</span></label>
                    <input type="text" name="contact_name" required>
                </div>

                <div class="form-group">
                    <label>Account Name <span>*</span></label>
                    <input type="text" name="account_name">
                </div>

                <div class="form-group full-width">
                    <label>Description <span>*</span></label>
                    <textarea id="description" name="description" required placeholder="Type issue details here..."></textarea>
                    <div class="help-text">Press Enter to improve the description quickly.</div>
                    <div class="desc-loader" id="descriptionLoader">Improving description...</div>
                </div>

                <div class="form-group">
                    <label>Status <span>*</span></label>
                    <select name="status" required>
                        <option value="">Select Status</option>
                        <option value="Open">Open</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Escalated">Escalated</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Assign To <span>*</span></label>
                    <input type="text" name="assign_to" required>
                </div>

                 <div class="form-group">
                    <label>QA by<span>*</span></label>
                    <input type="text" name="QA by" required>
                </div>
            </div>
        </div>

        <div class="form-box">
            <div class="section-title">Additional Information</div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Timeline</label>
                    <input type="datetime-local" name="timeline">
                </div>

                <div class="form-group">
                    <label>Priority <span>*</span></label>
                    <select name="priority" required>
                        <option value="">Select Priority</option>
                        <option value="Critical">Critical</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Classification <span>*</span></label>
                    <select name="classification" required>
                        <option value="">Select Classification</option>
                        <option value="Issue">Issue</option>
                        <option value="Update">Update</option>
                        <option value="Feature">Feature</option>
                        <option value="Enhancement">Enhancement</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Attachments</label>
                    <input type="file" name="attachment[]" class="file-input" id="attachment" multiple>
                    <div id="attachment_preview" class="attachment-preview-wrap"></div>
                    <div id="attachment_empty" class="empty-preview">No files selected</div>
                </div>
            </div>
        </div>

        <div class="btn-row">
            <button type="submit" class="btn submit-btn">Submit</button>
            <a href="<?= base_url('tickets'); ?>" class="btn cancel-btn">Cancel</a>
        </div>

    </form>
</div>

<script>
let improveRequestRunning = false;

async function improveDescription(textarea, loaderId) {
    const text = textarea.value.trim();
    if (!text || improveRequestRunning) return;

    const loader = document.getElementById(loaderId);

    try {
        improveRequestRunning = true;
        if (loader) loader.style.display = 'block';

        const formData = new FormData();
        formData.append('description', text);

        const response = await fetch("<?= base_url('tickets/improve_description'); ?>", {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        if (data.status && data.description) {
            textarea.value = data.description.trim();
        }
    } catch (error) {
        console.error("Description improve error:", error);
    } finally {
        improveRequestRunning = false;
        if (loader) loader.style.display = 'none';
    }
}

const descriptionBox = document.getElementById("description");
if (descriptionBox) {
    descriptionBox.addEventListener("keydown", async function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            await improveDescription(this, 'descriptionLoader');
        }
    });
}

const attachmentStore = [];
const attachmentInput = document.getElementById('attachment');
const previewBox = document.getElementById('attachment_preview');
const emptyBox = document.getElementById('attachment_empty');

if (attachmentInput) {
    attachmentInput.addEventListener('change', function(e){
        const newFiles = Array.from(e.target.files || []);
        if (newFiles.length) {
            newFiles.forEach(file => attachmentStore.push(file));
        }
        syncFiles();
        renderPreview();
    });
}

function syncFiles() {
    const dt = new DataTransfer();
    attachmentStore.forEach(function(file){
        dt.items.add(file);
    });
    attachmentInput.files = dt.files;
}

function removeFile(index) {
    attachmentStore.splice(index, 1);
    syncFiles();
    renderPreview();
}

function renderPreview() {
    previewBox.innerHTML = '';

    if (!attachmentStore.length) {
        emptyBox.style.display = 'block';
        return;
    }

    emptyBox.style.display = 'none';

    attachmentStore.forEach(function(file, index){
        const card = document.createElement('div');
        card.className = 'attachment-card';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-file-btn';
        removeBtn.innerHTML = '&times;';
        removeBtn.onclick = function(){
            removeFile(index);
        };

        card.appendChild(removeBtn);

        if (file.type && file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            card.appendChild(img);
        } else {
            const icon = document.createElement('div');
            icon.className = 'attachment-file-icon';
            icon.innerHTML = '<i class="bi bi-file-earmark-arrow-up"></i>';
            card.appendChild(icon);
        }

        const name = document.createElement('div');
        name.className = 'attachment-name';
        name.textContent = file.name;
        card.appendChild(name);

        previewBox.appendChild(card);
    });
}
</script>

</body>
</html>