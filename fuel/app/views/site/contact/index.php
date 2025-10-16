<?= View::forge('site/partials/breadcrumb', isset($data) ? $data : array('breadcrumb_title' => isset($breadcrumb_title) ? $breadcrumb_title : 'Contact', 'breadcrumb_items' => isset($breadcrumb_items) ? $breadcrumb_items : array())) ?>
<section class="contact-section spad">
    <div class="container">
        <?php if (\Session::get_flash('success')): ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.Swal) {
                    Swal.fire({ icon: 'success', title: 'Thành công', text: '<?= addslashes(\Session::get_flash('success')) ?>' });
                }
            });
            </script>
        <?php endif; ?>
        <?php if (\Session::get_flash('error')): ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.Swal) {
                    Swal.fire({ icon: 'error', title: 'Lỗi', text: '<?= addslashes(\Session::get_flash('error')) ?>' });
                }
            });
            </script>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="contact-text">
                    <h2>Contact Info</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                    <table>
                        <tbody>
                        <tr>
                            <td class="c-o">Address:</td>
                            <td>265 Đ. Cầu Giấy, Dịch Vọng, Cầu Giấy, Hà Nội, Vietnam</td>
                        </tr>
                        <tr>
                            <td class="c-o">Phone:</td>
                            <td>0974388461</td>
                        </tr>
                        <tr>
                            <td class="c-o">Email:</td>
                            <td>ducquy23102003@gmail.com</td>
                        </tr>
                        <tr>
                            <td class="c-o">Fax:</td>
                            <td>+(12) 345 67890</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <form method="POST" action="<?= \Uri::create('contact') ?>" class="contact-form">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" name="name" placeholder="Your Name" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                        </div>
                        <div class="col-lg-6">
                            <input type="email" name="email" placeholder="Your Email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="phone" placeholder="Your Phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="subject" placeholder="Subject" value="<?= htmlspecialchars($old['subject'] ?? '') ?>">
                        </div>
                        <div class="col-lg-12">
                            <textarea name="message" placeholder="Your Message"><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                            <button type="submit">Submit Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.954102775859!2d105.79232691127066!3d21.034522387498917!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab4795e5d9fd%3A0x28d2c2430b59908!2zMjY1IMSQLiBD4bqndSBHaeG6pXksIEThu4tjaCBW4buNbmcsIEPhuqd1IEdp4bqleSwgSMOgIE7hu5lpLCBWaWV0bmFt!5e0!3m2!1sen!2s!4v1760438542593!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>