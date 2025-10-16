(function(){
  // Services: delete
  document.addEventListener('click', function (e) {
    var target = e.target && e.target.closest ? e.target.closest('a.js-delete-service') : null;
    if (!target) return;
    e.preventDefault();
    var url = target.getAttribute('data-url') || target.getAttribute('href');
    if (!url) return;
    if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn xóa dịch vụ này?')) location.href = url; return; }
    Swal.fire({
      title: 'Bạn chắc chắn?',
      text: 'Hành động này không thể hoàn tác!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Xóa',
      cancelButtonText: 'Hủy',
      customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-outline-secondary ms-1' },
      buttonsStyling: false
    }).then(function(res){ if (res.isConfirmed) location.href = url; });
  });

  // Admins: toggle & reset
  document.addEventListener('click', function (e) {
    var t = e.target && e.target.closest ? e.target.closest('a.js-admin-toggle') : null;
    if (t) {
      e.preventDefault();
      var url = t.getAttribute('data-url') || t.getAttribute('href');
      if (!url) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn thay đổi trạng thái admin này?')) location.href = url; return; }
      Swal.fire({
        title: 'Thay đổi trạng thái?',
        text: 'Admin sẽ được kích hoạt / vô hiệu hóa.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-primary', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url; });
    }

    var r = e.target && e.target.closest ? e.target.closest('a.js-admin-reset') : null;
    if (r) {
      e.preventDefault();
      var url2 = r.getAttribute('data-url') || r.getAttribute('href');
      if (!url2) return;
      if (typeof Swal === 'undefined') { if (confirm('Reset mật khẩu admin này?')) location.href = url2; return; }
      Swal.fire({
        title: 'Reset mật khẩu?',
        text: 'Mật khẩu mới sẽ được tạo ngẫu nhiên.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Reset',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-danger', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url2; });
    }
  });

  // Hotels: toggle & delete
  document.addEventListener('click', function (e) {
    var th = e.target && e.target.closest ? e.target.closest('a.js-hotel-toggle') : null;
    if (th) {
      e.preventDefault();
      var url = th.getAttribute('data-url') || th.getAttribute('href');
      if (!url) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn thay đổi trạng thái khách sạn này?')) location.href = url; return; }
      Swal.fire({
        title: 'Thay đổi trạng thái?',
        text: 'Khách sạn sẽ được kích hoạt / tạm dừng.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-primary', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url; });
    }

    var dh = e.target && e.target.closest ? e.target.closest('a.js-hotel-delete') : null;
    if (dh) {
      e.preventDefault();
      var url2 = dh.getAttribute('data-url') || dh.getAttribute('href');
      if (!url2) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn xóa khách sạn này?')) location.href = url2; return; }
      Swal.fire({
        title: 'Xóa khách sạn?',
        text: 'Hành động không thể hoàn tác!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-danger', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url2; });
    }
  });

  // Rooms: toggle & delete
  document.addEventListener('click', function (e) {
    var tr = e.target && e.target.closest ? e.target.closest('a.js-room-toggle') : null;
    if (tr) {
      e.preventDefault();
      var url = tr.getAttribute('data-url') || tr.getAttribute('href');
      if (!url) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn thay đổi trạng thái phòng này?')) location.href = url; return; }
      Swal.fire({
        title: 'Thay đổi trạng thái?',
        text: 'Phòng sẽ được kích hoạt / tạm dừng.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-primary', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url; });
    }

    var dr = e.target && e.target.closest ? e.target.closest('a.js-room-delete') : null;
    if (dr) {
      e.preventDefault();
      var url2 = dr.getAttribute('data-url') || dr.getAttribute('href');
      if (!url2) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn xóa phòng này?')) location.href = url2; return; }
      Swal.fire({
        title: 'Xóa phòng?',
        text: 'Hành động không thể hoàn tác!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-danger', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url2; });
    }
  });

  // Categories: toggle & delete
  document.addEventListener('click', function (e) {
    var tc = e.target && e.target.closest ? e.target.closest('a.js-category-toggle') : null;
    if (tc) {
      e.preventDefault();
      var url = tc.getAttribute('data-url') || tc.getAttribute('href');
      if (!url) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn thay đổi trạng thái loại khách sạn này?')) location.href = url; return; }
      Swal.fire({
        title: 'Thay đổi trạng thái?',
        text: 'Loại khách sạn sẽ được kích hoạt / tạm dừng.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-primary', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url; });
    }

    var dc = e.target && e.target.closest ? e.target.closest('a.js-category-delete') : null;
    if (dc) {
      e.preventDefault();
      var url2 = dc.getAttribute('data-url') || dc.getAttribute('href');
      if (!url2) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn xóa loại khách sạn này?')) location.href = url2; return; }
      Swal.fire({
        title: 'Xóa loại khách sạn?',
        text: 'Hành động không thể hoàn tác!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-danger', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url2; });
    }
  });

  // Amenities: toggle & delete
  document.addEventListener('click', function (e) {
    var ta = e.target && e.target.closest ? e.target.closest('a.js-amenity-toggle') : null;
    if (ta) {
      e.preventDefault();
      var url = ta.getAttribute('data-url') || ta.getAttribute('href');
      if (!url) return;
      if (typeof Swal === 'undefined') { if (confirm('Đổi trạng thái tiện ích này?')) location.href = url; return; }
      Swal.fire({
        title: 'Đổi trạng thái?',
        text: 'Tiện ích sẽ được kích hoạt / tạm dừng.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-primary', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url; });
    }

    var da = e.target && e.target.closest ? e.target.closest('a.js-amenity-delete') : null;
    if (da) {
      e.preventDefault();
      var url2 = da.getAttribute('data-url') || da.getAttribute('href');
      if (!url2) return;
      if (typeof Swal === 'undefined') { if (confirm('Xóa tiện ích này?')) location.href = url2; return; }
      Swal.fire({
        title: 'Xóa tiện ích?',
        text: 'Hành động không thể hoàn tác!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-danger', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url2; });
    }
  });

  // Blogs: toggle & delete
  document.addEventListener('click', function (e) {
    var tb = e.target && e.target.closest ? e.target.closest('a.js-blog-toggle') : null;
    if (tb) {
      e.preventDefault();
      var url = tb.getAttribute('data-url') || tb.getAttribute('href');
      if (!url) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn thay đổi trạng thái blog này?')) location.href = url; return; }
      Swal.fire({
        title: 'Thay đổi trạng thái?',
        text: 'Bài viết sẽ được xuất bản / tạm dừng.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-primary', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url; });
    }

    var db = e.target && e.target.closest ? e.target.closest('a.js-blog-delete') : null;
    if (db) {
      e.preventDefault();
      var url2 = db.getAttribute('data-url') || db.getAttribute('href');
      if (!url2) return;
      if (typeof Swal === 'undefined') { if (confirm('Bạn có chắc muốn xóa blog này?')) location.href = url2; return; }
      Swal.fire({
        title: 'Xóa bài viết?',
        text: 'Hành động không thể hoàn tác!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        customClass: {confirmButton: 'btn btn-danger', cancelButton: 'btn btn-outline-secondary ms-1'},
        buttonsStyling: false
      }).then(function(res){ if (res.isConfirmed) location.href = url2; });
    }
  });

  // Blog: delete image
  document.addEventListener('click', function (e) {
    var target = e.target && e.target.closest ? e.target.closest('button.js-delete-blog-image') : null;
    if (!target) return;
    e.preventDefault();
    var blogId = target.getAttribute('data-blog-id');
    if (!blogId) return;
    if (typeof Swal === 'undefined') { 
      if (confirm('Bạn có chắc muốn xóa ảnh đại diện này?')) {
        // Fallback to form submission if SweetAlert2 not available
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/blogs/delete-image/' + blogId;
        document.body.appendChild(form);
        form.submit();
      }
      return; 
    }
    Swal.fire({
      title: 'Xác nhận xóa ảnh',
      text: 'Bạn có chắc muốn xóa ảnh đại diện này?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Xóa',
      cancelButtonText: 'Hủy',
      customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-outline-secondary ms-1' },
      buttonsStyling: false
    }).then(function(res){ 
      if (res.isConfirmed) {
        fetch('/admin/blogs/delete-image/' + blogId, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            blog_id: blogId
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            target.closest('.mb-3').remove();
            Swal.fire({
              title: 'Thành công!',
              text: 'Đã xóa ảnh thành công',
              icon: 'success',
              timer: 2000,
              showConfirmButton: false
            });
          } else {
            Swal.fire({
              title: 'Lỗi!',
              text: data.message || 'Có lỗi xảy ra',
              icon: 'error'
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire({
            title: 'Lỗi!',
            text: 'Có lỗi xảy ra khi xóa ảnh',
            icon: 'error'
          });
        });
      }
    });
  });
})();



