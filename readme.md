# Yiontech LMS

**Contributors:** Yiontech Ltd  
**Requires at least:** 6.0  
**Tested up to:** 6.6  
**Requires PHP:** 7.4  
**Stable tag:** 1.0.0  
**License:** Commercial (see LICENSE.txt)  
**License URI:** LICENSE.txt  
**Tags:** lms, education, e-learning, online courses, tutor lms, student dashboard  

---

## Description

Yiontech LMS is a **premium WordPress theme** developed by **Yiontech Ltd**.  
It is designed for **educational institutions, training providers, and online academies**, offering a complete solution for building modern learning platforms with **Tutor LMS integration**.  

This theme includes:  
- Custom authentication system (AJAX login & registration)  
- Private document uploads per student  
- Professional UI layouts optimized for engagement and usability  

### Key Features
- 🔑 Custom Login Page with AJAX authentication  
- 📝 Custom Registration Page with file upload (documents stored privately per user)  
- 🎓 Tutor LMS dashboard integration with overridden login/registration URLs  
- 📄 Auto-creates `/login` and `/register` pages with dedicated blank templates (no header/footer)  
- 🔒 Secure nonce and validation on all forms  
- 🔐 Password strength meter with show/hide toggle  
- 📂 Drag & drop file upload area during registration  
- 🎨 Tailwind CSS powered UI for modern styling  
- 📱 Responsive two-column layout (marketing + form)  
- ⚡ Branded alert messages (success, warning, error)  
- 🔄 Student redirect handling (`redirect_to` supported — users return to the page they intended after login/registration)  

---

## Installation

1. Upload the theme ZIP via **WordPress > Appearance > Themes > Add New**.  
2. Activate the theme.  
3. The theme will automatically create:  
   - `/login` page using the custom blank login template  
   - `/register` page using the custom blank registration template  
4. Visit **Appearance > Customize** to adjust branding and styling.  
5. Ensure **Tutor LMS** is installed and configured.  

---

## Frequently Asked Questions

### ❓ Does this theme work without Tutor LMS?  
Yes, but it is built and optimized for Tutor LMS. Some functionality (like dashboard redirects) requires Tutor LMS.  

### ❓ Where are uploaded documents stored?  
Documents are stored privately under:  

` wp-content/uploads/yiontech-lms-private/{user_id}/`

They are **not publicly accessible** via direct URL.  

### ❓ Can I modify the templates?  
Yes. Templates are located in the `inc/features/` directory and can be overridden in your **child theme**.  

### ❓ Does it support WordPress default login/register?  
The theme overrides Tutor LMS login/register URLs and enforces **custom `/login` and `/register` pages** with improved UI/UX.  

---

## Changelog

### 1.0.0
- Initial release  
- Custom login/registration modules  
- AJAX form handling  
- Tutor LMS integration  
- Private file upload support  
- Tailwind CSS UI layouts  
- Redirect-to support for user experience  

---

## License

This theme is a **commercial product** of **Yiontech Ltd**.  
See `LICENSE.txt` for full license terms.  
🚫 Unauthorized distribution is strictly prohibited.  

---

## Support

For support, updates, or licensing inquiries, contact:  

**Yiontech Ltd**  
📧 Email: [support@yiontech.co.uk](mailto:support@yiontech.co.uk)  
🌐 Website: [https://yiontech.co.uk](https://yiontech.co.uk)  
