<div class="card">
    <div class="card-header">
        <div class="col-md-12 mb-2">
            <a href="<?= \Uri::create('admin/contacts') ?>" class="btn btn-secondary">
                <i data-feather="arrow-left" class="font-small-4 me-50"></i>
                Quay lại
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Chi tiết Liên hệ</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <h5 class="mb-2">Thông tin liên hệ</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <strong>Tên:</strong> <?= $contact['name'] ?>
                            </div>
                            <div class="mb-2">
                                <strong>Email:</strong> 
                                <a href="mailto:<?= htmlspecialchars($contact['email']) ?>">
                                    <?= htmlspecialchars($contact['email']) ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <strong>Số điện thoại:</strong> 
                                <?= $contact['phone'] ? htmlspecialchars($contact['phone']) : 'N/A' ?>
                            </div>
                            <div class="mb-2">
                                <strong>Ngày gửi:</strong> 
                                <?= date('d/m/Y H:i:s', strtotime($contact['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h5>Chủ đề</h5>
                    <p class="border p-3 rounded"><?= $contact['subject'] ?></p>
                </div>
                
                <div class="mb-3">
                    <h5>Nội dung</h5>
                    <div class="border p-3 rounded" style="min-height: 200px;">
                        <?= $contact['message'] ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Trạng thái</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $badge_class = Model_Contact::get_status_badge_class($contact['status']);
                        $status_text = Model_Contact::get_status_options()[$contact['status']] ?? $contact['status'];
                        ?>
                        <div class="mb-3">
                            <span class="badge rounded-pill <?= $badge_class ?> fs-6"><?= $status_text ?></span>
                        </div>
                        
                        <form method="POST" action="<?= \Uri::create('admin/contacts/update_status/' . $contact['id']) ?>">
                            <div class="mb-3">
                                <label class="form-label">Cập nhật trạng thái</label>
                                <select name="status" class="form-select">
                                    <?php foreach (Model_Contact::get_status_options() as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= $contact['status'] === $value ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                        </form>
                        
                        <hr>
                        
                        <div class="d-grid gap-2">
                            <a href="mailto:<?= htmlspecialchars($contact['email']) ?>?subject=Re: <?= urlencode($contact['subject']) ?>" 
                               class="btn btn-success">
                                <i data-feather="mail" class="font-small-4 me-50"></i>
                                Trả lời Email
                            </a>
                            
                            <a href="<?= \Uri::create('admin/contacts/delete/' . $contact['id']) ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
                                <i data-feather="trash" class="font-small-4 me-50"></i>
                                Xóa liên hệ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
