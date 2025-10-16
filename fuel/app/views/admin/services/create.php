<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Tạo Dịch vụ</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/services') ?>">Dịch vụ</a></li>
                        <li class="breadcrumb-item active">Tạo Dịch vụ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= \Uri::create('admin/services/create') ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-1">
                        <label class="form-label" for="name">Tên dịch vụ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?= htmlspecialchars(\Input::post('name', '')) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php echo View::forge('admin/components/icon_picker', array(
                        'name' => 'icon',
                        'value' => \Input::post('icon', ''),
                        'label' => 'Icon',
                        'placeholder' => 'Chọn icon'
                    )); ?>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="price">Giá</label>
                        <div class="input-group">
                            <span class="input-group-text">VNĐ</span>
                            <input type="number" class="form-control" id="price" name="price"
                                   value="<?= htmlspecialchars(\Input::post('price', '')) ?>"
                                   placeholder="Nhập giá (để trống nếu miễn phí)" min="0" step="1000">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="status">Trạng thái <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?= \Input::post('status', 'active') === 'active' ? 'selected' : '' ?>>
                                Hoạt động
                            </option>
                            <option value="inactive" <?= \Input::post('status') === 'inactive' ? 'selected' : '' ?>Tạm
                                    dừng
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label" for="description">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" maxlength="1000"
                              placeholder="Mô tả chi tiết về dịch vụ... (tối đa 1000 ký tự)">
                        <?= htmlspecialchars(\Input::post('description', '')) ?>
                    </textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <a href="<?= \Uri::create('admin/services') ?>" class="btn btn-outline-secondary me-1 waves-effect">Hủy</a>
                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Tạo Dịch vụ</button>

                </div>
            </div>
        </form>
    </div>

    <script>
        (function () {
            // live icon preview
            var iconSelect = document.getElementById('icon');
            var iconPreview = document.getElementById('iconPreview');
            if (iconSelect && iconPreview) {
                iconSelect.addEventListener('change', function () {
                    var val = this.value || 'star';
                    iconPreview.innerHTML = '<span class="avatar-initial rounded-circle bg-label-primary d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;"><i class="feather ' + val + '"></i></span>';
                });
            }

            // description counter
            var desc = document.getElementById('description');
            var counter = document.getElementById('descCount');
            if (desc && counter) {
                var update = function () {
                    counter.textContent = desc.value.length;
                };
                desc.addEventListener('input', update);
                update();
            }
        })();
    </script>
