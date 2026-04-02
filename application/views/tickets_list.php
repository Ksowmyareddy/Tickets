<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif;}
        body{background:#eef5ff;color:#133b6b;padding:18px 14px;}
        .page-wrap{max-width:1600px;margin:0 auto;}

        .topbar{
            background:#ffffff;
            border:1px solid #cfe2ff;
            border-radius:12px;
            padding:12px 14px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:12px;
            box-shadow:0 8px 22px rgba(13,110,253,0.08);
            gap:10px;
            flex-wrap:wrap;
        }

        .topbar-left,.topbar-right{
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
        }

        .page-title{font-size:18px;font-weight:700;color:#0d6efd;}



.brand-logo{
    width:105px;
    height:42px;
    object-fit:contain;
    display:block;
}

       .search-form{
    display:flex;
    align-items:center;
    gap:3px;
    background:#f8fbff;
    border:1px solid #cfe2ff;
    border-radius:6px;
    padding:3px 6px;   /* reduced */
}

.search-input{
    border:none;
    outline:none;
    background:transparent;
    color:#133b6b;
    min-width:100px;   /* reduced width */
    font-size:12px;    /* smaller text */
}

.search-btn{
    background:#0d6efd;
    padding:5px 10px;  /* smaller button */
    font-size:11px;    /* smaller text */
}


.clear-btn{
    width:22px;        /* smaller */
    height:22px;
    font-size:10px;
}

        .btn{
            border:none;
            border-radius:8px;
            padding:7px 12px;
            font-size:12px;
            font-weight:600;
            cursor:pointer;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            transition:0.2s ease;
        }

        .search-btn{background:#0d6efd;}
        .search-btn:hover{background:#0b5ed7;}

        .clear-btn{
            display:flex;
            align-items:center;
            justify-content:center;
            width:20px;
            height:28px;
            border-radius:50%;
            background:#e7f0ff;
            color:#0d6efd;
            text-decoration:none;
            font-size:10px;
            transition:0.2s;
        }

        .clear-btn:hover{background:#0d6efd;color:#fff;}
        .excel-btn{background:#198754;}
        .excel-btn:hover{background:#157347;}
        .create-btn{background:#0d6efd;}
        .create-btn:hover{background:#0b5ed7;}

        .flash-message{
            padding:10px 14px;
            border-radius:8px;
            margin-bottom:12px;
            font-size:13px;
            font-weight:600;
            transition:opacity 0.5s ease, transform 0.5s ease;
        }

        .flash-success{background:#e9f7ef;color:#198754;border:1px solid #b7e4c7;}
        .flash-error{background:#fff0f0;color:#dc3545;border:1px solid #f1b0b7;}
        .flash-hide{opacity:0;transform:translateY(-8px);}

        .inline-toast{
            position:fixed;
            top:20px;
            right:20px;
            background:#0d6efd;
            color:#fff;
            padding:9px 13px;
            border-radius:8px;
            font-size:12px;
            font-weight:600;
            box-shadow:0 6px 16px rgba(0,0,0,0.18);
            display:none;
            z-index:99999;
        }

        .inline-toast.error{background:#dc3545;}

        .table-card{
            background:#ffffff;
            border:1px solid #cfe2ff;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 8px 24px rgba(13,110,253,0.08);
        }

        .table-wrap{overflow-x:auto;}
        table{width:100%;min-width:1750px;border-collapse:collapse;}
        thead{background:#0d6efd;}

        th{
            color:#ffffff;
            font-size:12px;
            font-weight:700;
            text-align:left;
            padding:12px 10px;
            border-bottom:1px solid #5fa0ff;
            white-space:nowrap;
        }

        td{
            color:#133b6b;
            font-size:12px;
            padding:10px 10px;
            border-bottom:1px solid #e2efff;
            vertical-align:top;
            background:#ffffff;
            line-height:1.4;
        }

        tbody tr:hover td{background:#f7fbff;}
        .no-data{text-align:center;color:#7c95b2;padding:18px 0;}

        .attachment-summary-btn{
            display:inline-flex;
            align-items:center;
            gap:7px;
            background:#eef5ff;
            color:#0d6efd;
            border:1px solid #cfe2ff;
            border-radius:999px;
            padding:5px 10px;
            cursor:pointer;
            font-size:12px;
            font-weight:700;
            transition:0.2s;
        }

        .attachment-summary-btn:hover{
            background:#0d6efd;
            color:#fff;
        }

        .attachment-count{
            font-size:11px;
            font-weight:700;
        }

        .desc-cell{max-width:300px;}
        .desc-short{
            display:-webkit-box;
            -webkit-line-clamp:2;
            line-clamp:2;
            -webkit-box-orient:vertical;
            overflow:hidden;
            line-height:1.4;
            word-break:break-word;
            max-width:260px;
        }

        .ticket-id{color:#0d6efd;font-weight:700;cursor:pointer;}

        .status-select,.timeline-input{
            background:#ffffff;
            color:#133b6b;
            border:1px solid #bfd7ff;
            border-radius:6px;
            padding:5px 7px;
            font-size:12px;
            width:100%;
        }

        .autosaving{opacity:0.6;pointer-events:none;}

        .edit-link{
            display:inline-flex;
            align-items:center;
            gap:6px;
            color:#0d6efd;
            font-size:13px;
            font-weight:700;
            cursor:pointer;
            text-decoration:none;
            padding:4px 2px;
            transition:0.2s ease;
        }

        .edit-link:hover{
            color:#084298;
            transform:translateX(2px);
        }

        .edit-link i{
            font-size:14px;
        }

        .modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.55);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
    padding:16px;
}
#ticketModal{
    z-index:9999;
}

#updateTicketModal{
    z-index:10000;
}

#attachmentsGalleryModal{
    z-index:10020;
}

#imagePreviewModal{
    z-index:10050;
}
        

        .modal-box{
            width:100%;
            max-width:980px;
            max-height:90vh;
            overflow-y:auto;
            background:#ffffff;
            border:1px solid #cfe2ff;
            border-radius:14px;
            box-shadow:0 18px 40px rgba(0,0,0,0.20);
            padding:18px;
        }

        .modal-header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:14px;
        }

        .modal-header h2{font-size:18px;color:#0d6efd;}
        .close-btn{
            background:transparent;
            border:none;
            color:#0d6efd;
            font-size:26px;
            cursor:pointer;
            line-height:1;
        }

        .form-box{
            background:#ffffff;
            border-radius:12px;
            padding:18px 16px;
            margin-bottom:14px;
            border:1px solid #cfe2ff;
        }

        .section-title{
            font-size:15px;
            font-weight:700;
            color:#0d6efd;
            margin-bottom:16px;
        }

        .form-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:18px 16px;
        }

        .form-group{display:flex;flex-direction:column;}
        .full-width{grid-column:1 / 3;}

        .form-group label{
            font-size:12px;
            color:#0f3d7a;
            margin-bottom:7px;
            font-weight:600;
        }

        .form-group label span{color:#ff5c5c;}

        .form-group input[type="text"],
        .form-group input[type="datetime-local"],
        .form-group textarea,
        .form-group select{
            width:100%;
            background:#ffffff;
            border:none;
            border-bottom:2px solid #bfd7ff;
            color:#133b6b;
            font-size:13px;
            padding:6px 2px 8px 2px;
            outline:none;
        }

        .form-group textarea{
            min-height:90px;
            resize:vertical;
            line-height:1.5;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus{
            border-bottom:2px solid #0d6efd;
        }

        .file-input{
            width:100%;
            background:#f8fbff !important;
            border:1px solid #bfd7ff !important;
            border-radius:8px;
            color:#133b6b;
            padding:8px !important;
        }

        .help-text{font-size:11px;color:#6b89b0;margin-top:6px;line-height:1.4;}
        .desc-loader{display:none;margin-top:6px;font-size:11px;color:#0d6efd;font-weight:600;}
        .submit-btn{background:#0d6efd;color:#fff;}
        .submit-btn:hover{background:#0b5ed7;}
        .cancel-btn{background:#7c8796;color:#fff;}
        .cancel-btn:hover{background:#6d7785;}
        .btn-row{display:flex;gap:8px;flex-wrap:wrap;}

        .image-preview-modal{max-width:900px;padding:16px;}
        .image-preview-body{
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:280px;
            background:#f8fbff;
            border:1px solid #dbeaff;
            border-radius:8px;
            padding:12px;
        }

        .image-preview-body img{
            max-width:100%;
            max-height:70vh;
            border-radius:6px;
            object-fit:contain;
            box-shadow:0 6px 20px rgba(0,0,0,0.15);
        }

        .attachments-gallery-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
            gap:14px;
        }

        .gallery-card{
            border:1px solid #d8e7ff;
            border-radius:12px;
            background:#f8fbff;
            padding:10px;
            text-align:center;
            cursor:pointer;
            transition:0.2s ease;
        }

        .gallery-card:hover{
            transform:translateY(-2px);
            box-shadow:0 8px 18px rgba(13,110,253,0.12);
            border-color:#9fc4ff;
        }

        .gallery-card img{
            width:100%;
            height:130px;
            object-fit:cover;
            border-radius:8px;
            margin-bottom:8px;
        }

        .gallery-icon{
            font-size:40px;
            color:#0d6efd;
            margin:18px 0 12px 0;
        }

        .overdue-row td{
            background:#fff8f8 !important;
        }

        .overdue-text{
            color:#dc3545 !important;
            font-weight:700;
        }

        .timeline-overdue{
            border:1px solid #dc3545 !important;
            color:#dc3545 !important;
            background:#fff5f5 !important;
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

        .existing-file-badge{
            position:relative;
        }

        .empty-preview{
            font-size:11px;
            color:#7c95b2;
            margin-top:8px;
        }

        @media (max-width: 768px){
            .topbar{flex-direction:column;align-items:flex-start;gap:10px;}
            .topbar-right{align-self:flex-start;flex-wrap:wrap;}
            .page-title{font-size:17px;}
            .modal-box{padding:14px;}
            .form-grid{grid-template-columns:1fr;}
            .full-width{grid-column:auto;}
            .search-input{min-width:150px;}
        }
    </style>
</head>
<body>

<div class="inline-toast" id="inlineToast"></div>

<div class="page-wrap">

    <?php if ($this->session->flashdata('success')) { ?>
    <div class="flash-message flash-success auto-hide-message"><?= $this->session->flashdata('success'); ?></div>
    <?php } ?>

    <?php if ($this->session->flashdata('error')) { ?>
    <div class="flash-message flash-error auto-hide-message"><?= $this->session->flashdata('error'); ?></div>
    <?php } ?>

    <div class="topbar">
        <div class="topbar-left">
           <div class="brand">
    <img src="<?= base_url('assets/images/autozilla.png'); ?>" alt="Autozilla Logo" class="brand-logo">
   
</div>
            <form method="get" action="<?= base_url('tickets'); ?>" class="search-form">
                <i class="bi bi-search" style="color:#0d6efd;"></i>
                <input type="text" name="search" class="search-input"
                       placeholder="Search by Ticket ID, Contact Name, Account Name, Description"
                       value="<?= isset($search) ? htmlspecialchars($search) : ''; ?>">
                <button type="submit" class="btn search-btn">Search</button>

                <?php if (!empty($search)) { ?>
                    <a href="<?= base_url('tickets'); ?>" class="clear-btn" title="Clear Search">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php } ?>
            </form>
        </div>

        <div class="topbar-right">
            <div class="page-title">Tickets (<?= $ticket_count; ?>)</div>

            <button type="button" class="btn create-btn" onclick="openTicketModal()">
                <i class="bi bi-plus-lg" style="margin-right:6px;"></i> Create
            </button>

            <a href="<?= base_url('tickets/export') . (!empty($search) ? '?search=' . urlencode($search) : ''); ?>" class="btn excel-btn">Excel</a>
        </div>
    </div>

    <div class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Contact Name</th>
                        <th>Account Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Timeline</th>
                        <th>Priority</th>
                        <th>Classification</th>
                        <th>Assign To</th>
                        <th>Attachments</th>
                        <th>Access</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($tickets)) { ?>
                        <?php foreach ($tickets as $ticket) { ?>
                            <?php
                                $attachments = array();
                                if (!empty($ticket->attachment)) {
                                    $decodedAttachments = json_decode($ticket->attachment, true);
                                    if (is_array($decodedAttachments)) {
                                        $attachments = $decodedAttachments;
                                    } else {
                                        $attachments = array_filter(array_map('trim', explode(',', $ticket->attachment)));
                                    }
                                }

                                $status_lower = strtolower(trim((string)$ticket->status));
                                $is_active_status = in_array($status_lower, array('open', 'on hold', 'escalated'));
                                $is_overdue = false;

                                if (!empty($ticket->timeline) && $ticket->timeline != '0000-00-00 00:00:00' && $is_active_status) {
                                    $is_overdue = (strtotime($ticket->timeline) < time());
                                }
                            ?>
                            <tr id="ticket-row-<?= $ticket->id; ?>" class="<?= $is_overdue ? 'overdue-row' : ''; ?>">
                                <td class="ticket-id <?= $is_overdue ? 'overdue-text' : ''; ?>">
                                    AZ<?= str_pad($ticket->id, 7, '0', STR_PAD_LEFT); ?>
                                </td>

                                <td class="<?= $is_overdue ? 'overdue-text' : ''; ?>">
                                    <?= htmlspecialchars($ticket->contact_name); ?>
                                </td>

                                <td><?= htmlspecialchars($ticket->account_name); ?></td>

                                <td class="desc-cell">
                                    <span class="desc-short <?= $is_overdue ? 'overdue-text' : ''; ?>" title="<?= htmlspecialchars((string)$ticket->description); ?>">
                                        <?= htmlspecialchars((string)$ticket->description); ?>
                                    </span>
                                </td>

                                <td>
                                    <select name="status" class="status-select" data-id="<?= $ticket->id; ?>">
                                        <option value="Open" <?= $ticket->status == 'Open' ? 'selected' : ''; ?>>Open</option>
                                        <option value="On Hold" <?= $ticket->status == 'On Hold' ? 'selected' : ''; ?>>On Hold</option>
                                        <option value="Escalated" <?= $ticket->status == 'Escalated' ? 'selected' : ''; ?>>Escalated</option>
                                        <option value="Closed" <?= $ticket->status == 'Closed' ? 'selected' : ''; ?>>Closed</option>
                                    </select>
                                </td>

                                <td class="<?= $is_overdue ? 'overdue-text' : ''; ?>">
                                    <?= !empty($ticket->created_at) ? date('d-M-Y h:i A', strtotime($ticket->created_at)) : '-' ?>
                                </td>

                                <td>
                                    <input type="datetime-local"
                                           name="timeline"
                                           class="timeline-input <?= $is_overdue ? 'timeline-overdue' : ''; ?>"
                                           data-id="<?= $ticket->id; ?>"
                                           value="<?= !empty($ticket->timeline) ? date('Y-m-d\TH:i', strtotime($ticket->timeline)) : ''; ?>">
                                </td>

                                <td><?= htmlspecialchars($ticket->priority); ?></td>
                                <td><?= htmlspecialchars($ticket->classification); ?></td>
                                <td><?= htmlspecialchars($ticket->assign_to); ?></td>

                                <td>
                                    <?php if (!empty($attachments)) { ?>
                                        <button type="button"
                                                class="attachment-summary-btn"
                                                onclick='openAttachmentsGallery(<?= json_encode($attachments); ?>)'>
                                            <i class="bi bi-upload"></i>
                                            <span class="attachment-count">+<?= count($attachments); ?></span>
                                        </button>
                                    <?php } else { ?>
                                        -
                                    <?php } ?>
                                </td>

                                <td>
                                    <span class="edit-link" onclick="openEditById(<?= $ticket->id; ?>)">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit</span>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="12" class="no-data">No tickets found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- CREATE MODAL -->
<div id="ticketModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h2>Create Ticket</h2>
            <button type="button" class="close-btn" onclick="closeTicketModal()">&times;</button>
        </div>

        <form method="post" action="<?= base_url('tickets/store'); ?>" enctype="multipart/form-data">
            <div class="form-box">
                <div class="section-title">Ticket Information</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Contact Name <span>*</span></label>
                        <input type="text" name="contact_name" required>
                    </div>

                    <div class="form-group">
                        <label>Account Name</label>
                        <input type="text" name="account_name">
                    </div>

                    <div class="form-group full-width">
                        <label>Description <span>*</span></label>
                        <textarea id="description" name="description" required placeholder="Type issue details here..."></textarea>
                        <div class="help-text">Press Enter to improve description quickly.</div>
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
                        <input type="file" name="attachment[]" class="file-input" id="create_attachment" multiple>
                        <div id="create_attachment_preview" class="attachment-preview-wrap"></div>
                        <div id="create_attachment_empty" class="empty-preview">No files selected</div>
                    </div>
                </div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn submit-btn">Submit</button>
                <button type="button" class="btn cancel-btn" onclick="closeTicketModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- UPDATE MODAL -->
<div id="updateTicketModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h2>Update Ticket</h2>
            <button type="button" class="close-btn" onclick="closeUpdateTicketModal()">&times;</button>
        </div>

        <form method="post" action="<?= base_url('tickets/update_ticket'); ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" id="update_id">

            <div class="form-box">
                <div class="section-title">Ticket Information</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Contact Name <span>*</span></label>
                        <input type="text" name="contact_name" id="update_contact_name" required>
                    </div>

                    <div class="form-group">
                        <label>Account Name</label>
                        <input type="text" name="account_name" id="update_account_name">
                    </div>

                    <div class="form-group full-width">
                        <label>Description <span>*</span></label>
                        <textarea id="update_description" name="description" required></textarea>
                        <div class="help-text">Press Enter to improve description quickly.</div>
                        <div class="desc-loader" id="updateDescriptionLoader">Improving description...</div>
                    </div>

                    <div class="form-group">
                        <label>Status <span>*</span></label>
                        <select name="status" id="update_status" required>
                            <option value="Open">Open</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Escalated">Escalated</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Assign To <span>*</span></label>
                        <input type="text" name="assign_to" id="update_assign_to" required>
                    </div>
                </div>
            </div>

            <div class="form-box">
                <div class="section-title">Additional Information</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Timeline</label>
                        <input type="datetime-local" name="timeline" id="update_timeline">
                    </div>

                    <div class="form-group">
                        <label>Priority <span>*</span></label>
                        <select name="priority" id="update_priority" required>
                            <option value="Critical">Critical</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Classification <span>*</span></label>
                        <select name="classification" id="update_classification" required>
                            <option value="Issue">Issue</option>
                            <option value="Update">Update</option>
                            <option value="Feature">Feature</option>
                            <option value="Enhancement">Enhancement</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Existing Attachments</label>
                        <div id="existing_attachment_preview" class="attachment-preview-wrap"></div>
                        <div id="existing_attachment_empty" class="empty-preview">No existing files</div>
                    </div>

                    <div class="form-group">
                        <label>Add More Attachments</label>
                        <input type="file" name="attachment[]" class="file-input" id="update_attachment" multiple>
                        <div id="update_attachment_preview" class="attachment-preview-wrap"></div>
                        <div id="update_attachment_empty" class="empty-preview">No new files selected</div>
                    </div>
                </div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn submit-btn">Update</button>
                <button type="button" class="btn cancel-btn" onclick="closeUpdateTicketModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- SINGLE IMAGE PREVIEW -->
<div id="imagePreviewModal" class="modal-overlay">
    <div class="modal-box image-preview-modal">
        <div class="modal-header">
            <h2 id="imagePreviewTitle">Attachment Preview</h2>
            <button type="button" class="close-btn" onclick="closeImagePreview()">&times;</button>
        </div>

        <div class="image-preview-body">
            <img id="previewImage" src="" alt="Preview Image">
        </div>
    </div>
</div>

<!-- ALL ATTACHMENTS GALLERY -->
<div id="attachmentsGalleryModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h2>Attachments</h2>
            <button type="button" class="close-btn" onclick="closeAttachmentsGallery()">&times;</button>
        </div>
        <div id="attachmentsGalleryBody" class="attachments-gallery-grid"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const flashMessages = document.querySelectorAll('.auto-hide-message');
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            message.classList.add('flash-hide');
            setTimeout(function() {
                message.style.display = 'none';
            }, 500);
        }, 3000);
    });
});

const ticketsData = <?= json_encode($tickets); ?>;
const baseUploadUrl = "<?= base_url('uploads/tickets/'); ?>";

function showInlineToast(message, isError = false) {
    const toast = document.getElementById('inlineToast');
    toast.innerText = message;
    toast.className = isError ? 'inline-toast error' : 'inline-toast';
    toast.style.display = 'block';
    setTimeout(function () {
        toast.style.display = 'none';
    }, 1200);
}

function openTicketModal(){ document.getElementById('ticketModal').style.display = 'flex'; }
function closeTicketModal(){ document.getElementById('ticketModal').style.display = 'none'; }
function openUpdateTicketModal(){ document.getElementById('updateTicketModal').style.display = 'flex'; }
function closeUpdateTicketModal(){ document.getElementById('updateTicketModal').style.display = 'none'; }

function openAttachment(fileUrl, type){
    if(type === 'image'){
        document.getElementById('previewImage').src = fileUrl;
        document.getElementById('imagePreviewTitle').innerText = 'Attachment Preview';
        document.getElementById('imagePreviewModal').style.display = 'flex';
    } else {
        window.open(fileUrl, '_blank');
    }
}

function closeImagePreview(){
    document.getElementById('imagePreviewModal').style.display = 'none';
    document.getElementById('previewImage').src = '';
}

function openAttachmentsGallery(files){
    const galleryBody = document.getElementById('attachmentsGalleryBody');
    galleryBody.innerHTML = '';

    const imageExtensions = ['jpg','jpeg','png','gif','webp'];

    files.forEach(function(file){
        const ext = file.split('.').pop().toLowerCase();
        const fileUrl = baseUploadUrl + file;

        const card = document.createElement('div');
        card.className = 'gallery-card';
        card.onclick = function() {
            if (imageExtensions.includes(ext)) {
                openAttachment(fileUrl, 'image');
            } else {
                window.open(fileUrl, '_blank');
            }
        };

        if (imageExtensions.includes(ext)) {
            const img = document.createElement('img');
            img.src = fileUrl;
            img.alt = file;
            card.appendChild(img);
        } else {
            const icon = document.createElement('div');
            icon.className = 'gallery-icon';
            icon.innerHTML = '<i class="bi bi-file-earmark-text"></i>';
            card.appendChild(icon);
        }

        const name = document.createElement('div');
        name.className = 'attachment-name';
        name.textContent = file;

        card.appendChild(name);
        galleryBody.appendChild(card);
    });

    document.getElementById('attachmentsGalleryModal').style.display = 'flex';
}

function closeAttachmentsGallery(){
    document.getElementById('attachmentsGalleryModal').style.display = 'none';
    document.getElementById('attachmentsGalleryBody').innerHTML = '';
}

window.onclick = function(event){
    const createModal = document.getElementById('ticketModal');
    const updateModal = document.getElementById('updateTicketModal');
    const imageModal = document.getElementById('imagePreviewModal');
    const galleryModal = document.getElementById('attachmentsGalleryModal');

    if(event.target === createModal) closeTicketModal();
    if(event.target === updateModal) closeUpdateTicketModal();
    if(event.target === imageModal) closeImagePreview();
    if(event.target === galleryModal) closeAttachmentsGallery();
};

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

const updateDescriptionBox = document.getElementById("update_description");
if (updateDescriptionBox) {
    updateDescriptionBox.addEventListener("keydown", async function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            await improveDescription(this, 'updateDescriptionLoader');
        }
    });
}

async function autoSaveTicket(ticketId) {
    const row = document.getElementById('ticket-row-' + ticketId);
    if (!row) return;

    const statusField = row.querySelector('.status-select');
    const timelineField = row.querySelector('.timeline-input');

    const formData = new FormData();
    formData.append('id', ticketId);
    formData.append('status', statusField ? statusField.value : '');
    formData.append('timeline', timelineField ? timelineField.value : '');

    try {
        row.classList.add('autosaving');

        const response = await fetch("<?= base_url('tickets/update_inline'); ?>", {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        if (data.status) {
            showInlineToast('Auto-saved');
            setTimeout(function(){
                location.reload();
            }, 500);
        } else {
            showInlineToast(data.message || 'Save failed', true);
        }
    } catch (error) {
        console.error('Auto save error:', error);
        showInlineToast('Save failed', true);
    } finally {
        row.classList.remove('autosaving');
    }
}

document.querySelectorAll('.status-select').forEach(function(selectBox){
    selectBox.addEventListener('change', function(){
        autoSaveTicket(this.getAttribute('data-id'));
    });
});

document.querySelectorAll('.timeline-input').forEach(function(inputBox){
    inputBox.addEventListener('change', function(){
        autoSaveTicket(this.getAttribute('data-id'));
    });
});

const attachmentStores = {};
let existingUpdateFiles = [];

function initAttachmentPreview(inputId, previewId, emptyId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const empty = document.getElementById(emptyId);

    if (!input || !preview || !empty) return;

    attachmentStores[inputId] = [];

    input.addEventListener('change', function(e){
        const newFiles = Array.from(e.target.files || []);
        if (!newFiles.length) {
            renderAttachmentPreview(inputId, previewId, emptyId);
            return;
        }

        attachmentStores[inputId] = attachmentStores[inputId].concat(newFiles);
        syncInputFiles(inputId);
        renderAttachmentPreview(inputId, previewId, emptyId);
    });
}

function syncInputFiles(inputId) {
    const input = document.getElementById(inputId);
    if (!input) return;

    const dt = new DataTransfer();
    (attachmentStores[inputId] || []).forEach(function(file){
        dt.items.add(file);
    });
    input.files = dt.files;
}

function removeSelectedFile(inputId, index, previewId, emptyId) {
    if (!attachmentStores[inputId]) return;
    attachmentStores[inputId].splice(index, 1);
    syncInputFiles(inputId);
    renderAttachmentPreview(inputId, previewId, emptyId);
}

function resetAttachmentInput(inputId, previewId, emptyId) {
    attachmentStores[inputId] = [];
    const input = document.getElementById(inputId);
    if (input) input.value = '';
    syncInputFiles(inputId);
    renderAttachmentPreview(inputId, previewId, emptyId);
}

function renderAttachmentPreview(inputId, previewId, emptyId) {
    const preview = document.getElementById(previewId);
    const empty = document.getElementById(emptyId);
    const files = attachmentStores[inputId] || [];

    if (!preview || !empty) return;

    preview.innerHTML = '';

    if (!files.length) {
        empty.style.display = 'block';
        return;
    }

    empty.style.display = 'none';

    files.forEach(function(file, index){
        const card = document.createElement('div');
        card.className = 'attachment-card';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-file-btn';
        removeBtn.innerHTML = '&times;';
        removeBtn.onclick = function() {
            removeSelectedFile(inputId, index, previewId, emptyId);
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
        preview.appendChild(card);
    });
}

function renderExistingAttachments() {
    const preview = document.getElementById('existing_attachment_preview');
    const empty = document.getElementById('existing_attachment_empty');

    preview.innerHTML = '';

    document.querySelectorAll('.existing-attachment-hidden').forEach(function(el){
        el.remove();
    });

    if (!existingUpdateFiles.length) {
        empty.style.display = 'block';
        return;
    }

    empty.style.display = 'none';

    existingUpdateFiles.forEach(function(file, index){
        const card = document.createElement('div');
        card.className = 'attachment-card existing-file-badge';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-file-btn';
        removeBtn.innerHTML = '&times;';
        removeBtn.onclick = function() {
            existingUpdateFiles.splice(index, 1);
            renderExistingAttachments();
        };
        card.appendChild(removeBtn);

        const ext = file.split('.').pop().toLowerCase();
        const imageExt = ['jpg','jpeg','png','gif','webp'];

        if (imageExt.includes(ext)) {
            const img = document.createElement('img');
            img.src = baseUploadUrl + file;
            card.appendChild(img);
        } else {
            const icon = document.createElement('div');
            icon.className = 'attachment-file-icon';
            icon.innerHTML = '<i class="bi bi-file-earmark-text"></i>';
            card.appendChild(icon);
        }

        const name = document.createElement('div');
        name.className = 'attachment-name';
        name.textContent = file;
        card.appendChild(name);

        preview.appendChild(card);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'existing_attachments[]';
        hiddenInput.value = file;
        hiddenInput.className = 'existing-attachment-hidden';
        document.getElementById('updateTicketModal').querySelector('form').appendChild(hiddenInput);
    });
}

function openEditById(ticketId){
    const ticket = ticketsData.find(function(item){
        return parseInt(item.id) === parseInt(ticketId);
    });

    if (!ticket) {
        alert('Ticket not found');
        return;
    }

    document.getElementById('update_id').value = ticket.id;
    document.getElementById('update_contact_name').value = ticket.contact_name || '';
    document.getElementById('update_account_name').value = ticket.account_name || '';
    document.getElementById('update_description').value = ticket.description || '';
    document.getElementById('update_status').value = ticket.status || 'Open';
    document.getElementById('update_assign_to').value = ticket.assign_to || '';
    document.getElementById('update_priority').value = ticket.priority || 'Low';
    document.getElementById('update_classification').value = ticket.classification || 'Issue';

    if (ticket.timeline) {
        const d = new Date(ticket.timeline.replace(' ', 'T'));
        if (!isNaN(d.getTime())) {
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            const hour = String(d.getHours()).padStart(2, '0');
            const minute = String(d.getMinutes()).padStart(2, '0');
            document.getElementById('update_timeline').value = year + '-' + month + '-' + day + 'T' + hour + ':' + minute;
        } else {
            document.getElementById('update_timeline').value = '';
        }
    } else {
        document.getElementById('update_timeline').value = '';
    }

    existingUpdateFiles = [];
    if (ticket.attachment) {
        try {
            if (Array.isArray(ticket.attachment)) {
                existingUpdateFiles = ticket.attachment.filter(Boolean);
            } else {
                const parsed = JSON.parse(ticket.attachment);
                if (Array.isArray(parsed)) {
                    existingUpdateFiles = parsed.filter(Boolean);
                }
            }
        } catch (e) {
            existingUpdateFiles = [];
        }
    }

    resetAttachmentInput('update_attachment', 'update_attachment_preview', 'update_attachment_empty');
    renderExistingAttachments();
    openUpdateTicketModal();
}

initAttachmentPreview('create_attachment', 'create_attachment_preview', 'create_attachment_empty');
initAttachmentPreview('update_attachment', 'update_attachment_preview', 'update_attachment_empty');
</script>

</body>
</html>