<?php

class Controller_Site_Contact extends Controller_Template
{
    public $template = 'layouts/template_site';

	public function action_index()
	{
		$data = array();
		$data['breadcrumb_title'] = 'Contact';
		$data['breadcrumb_items'] = array(
			array('label' => 'Home', 'url' => \Uri::base()),
			array('label' => 'Contact')
		);

		if (\Input::method() === 'POST') {
			$name = trim((string) \Input::post('name', ''));
			$email = trim((string) \Input::post('email', ''));
			$phone = trim((string) \Input::post('phone', ''));
			$subject = trim((string) \Input::post('subject', ''));
			$message = trim((string) \Input::post('message', ''));

			$errors = array();
			if ($name === '') { $errors['name'] = 'Vui lòng nhập họ tên'; }
			if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Email không hợp lệ'; }
			if ($subject === '') { $errors['subject'] = 'Vui lòng nhập tiêu đề'; }
			if ($message === '') { $errors['message'] = 'Vui lòng nhập nội dung'; }

			if (empty($errors)) {
				try {
					\DB::query('INSERT INTO contacts (name, email, phone, subject, message, status, created_at, updated_at) VALUES (:name, :email, :phone, :subject, :message, :status, NOW(), NOW())')
						->parameters(array(
							':name' => $name,
							':email' => $email,
							':phone' => $phone !== '' ? $phone : null,
							':subject' => $subject,
							':message' => $message,
							':status' => 'new',
						))
						->execute();

					\Session::set_flash('success', 'Gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất.');
					\Response::redirect('contact');
				} catch (\Exception $e) {
					\Session::set_flash('error', 'Không thể gửi liên hệ: ' . $e->getMessage());
				}
			} else {
				$data['errors'] = $errors;
				$data['old'] = array(
					'name' => $name,
					'email' => $email,
					'phone' => $phone,
					'subject' => $subject,
					'message' => $message,
				);
			}
		}

		$this->template->title = 'Contact';
		$this->template->content = View::forge('site/contact/index', $data);
	}

}
