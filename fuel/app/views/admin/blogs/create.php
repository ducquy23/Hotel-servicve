<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Tạo Blog</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/blogs') ?>">Blog</a></li>
                        <li class="breadcrumb-item active">Tạo Blog</li>
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
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= \Uri::create('admin/blogs/create') ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label" for="title">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= htmlspecialchars(\Input::post('title', '')) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" for="content">Nội dung <span class="text-danger">*</span></label>
                        <div id="content-editor" style="height: 400px; border: 1px solid #ddd; border-radius: 4px;"></div>
                        <textarea name="content" id="content" style="display: none;" required><?= \Input::post('content', '') ?></textarea>
                        <small class="text-muted">Sử dụng thanh công cụ để định dạng nội dung</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" for="excerpt">Tóm tắt</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" 
                                  placeholder="Mô tả ngắn gọn về bài viết..."><?= htmlspecialchars(\Input::post('excerpt', '')) ?></textarea>
                        <small class="text-muted">Tối đa 500 ký tự</small>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Xuất bản</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="status">Trạng thái <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="draft" <?= \Input::post('status', 'draft') === 'draft' ? 'selected' : '' ?>>Bản nháp</option>
                                    <option value="published" <?= \Input::post('status') === 'published' ? 'selected' : '' ?>>Xuất bản</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="category">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php foreach ($categories as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= \Input::post('category') === $value ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="featured_image">Ảnh đại diện</label>
                                <input type="file" class="form-control" id="featured_image" name="featured_image" 
                                       accept="image/*">
                                <small class="text-muted">Chọn ảnh đại diện cho bài viết</small>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Tạo Blog</button>
                                <a href="<?= \Uri::create('admin/blogs') ?>" class="btn btn-secondary">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for Quill to be available
    if (typeof Quill === 'undefined') {
        console.error('Quill is not loaded');
        return;
    }
    
    // Initialize Quill editor
    var quill = new Quill('#content-editor', {
        theme: 'snow',
        placeholder: 'Nhập nội dung bài viết...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                ['clean']
            ]
        }
    });
    
    // Custom image handler
    var toolbar = quill.getModule('toolbar');
    toolbar.addHandler('image', function() {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();
        
        input.onchange = function() {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var range = quill.getSelection();
                    quill.insertEmbed(range.index, 'image', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        };
    });
    
    // Set initial content
    var contentTextarea = document.getElementById('content');
    if (contentTextarea && contentTextarea.value) {
        // Clean up the HTML content first
        var cleanContent = contentTextarea.value
            .replace(/&lt;/g, '<')
            .replace(/&gt;/g, '>')
            .replace(/&amp;/g, '&')
            .replace(/&quot;/g, '"')
            .replace(/&#39;/g, "'");
        
        console.log('Original content:', contentTextarea.value);
        console.log('Cleaned content:', cleanContent);
        
        // Set content directly to avoid parsing issues
        quill.root.innerHTML = cleanContent;
    }
    
    // Update textarea when content changes
    quill.on('text-change', function() {
        if (contentTextarea) {
            // Get clean HTML content
            contentTextarea.value = quill.root.innerHTML;
        }
    });
    
    // Form submission
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (contentTextarea) {
                // Ensure content is properly formatted
                contentTextarea.value = quill.root.innerHTML;
            }
        });
    }
    
    // Add some debugging
    console.log('Quill editor initialized successfully');
    console.log('Initial content:', contentTextarea ? contentTextarea.value : 'No content');
    
    // Character counter for excerpt
    var excerptTextarea = document.getElementById('excerpt');
    if (excerptTextarea) {
        var maxLength = 500;
        var counter = document.createElement('small');
        counter.className = 'text-muted';
        counter.style.display = 'block';
        counter.style.marginTop = '5px';
        excerptTextarea.parentNode.appendChild(counter);
        
        function updateCounter() {
            var remaining = maxLength - excerptTextarea.value.length;
            counter.textContent = 'Còn lại: ' + remaining + ' ký tự';
            if (remaining < 0) {
                counter.className = 'text-danger';
            } else {
                counter.className = 'text-muted';
            }
        }
        
        excerptTextarea.addEventListener('input', updateCounter);
        updateCounter();
    }
});
</script>
