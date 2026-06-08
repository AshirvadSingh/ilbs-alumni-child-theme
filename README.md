# ILBS Alumni Child Theme
**A Twenty Twenty-One WordPress Child Theme**

Converted from the v0 HTML/static prototype by Ashirvad.

---

## 📁 File Structure

```
ilbs-alumni-child-theme/
├── style.css                  ← Theme header + all custom CSS
├── functions.php              ← Enqueue, CPTs, taxonomies, AJAX, ACF JSON paths
├── header.php                 ← Overrides parent header
├── footer.php                 ← Overrides parent footer
├── front-page.php             ← Homepage (maps to index.html)
├── page.php                   ← Generic page template
├── page-about.php             ← About page (Template Name: About)
├── page-contact.php           ← Contact page (Template Name: Contact)
├── single.php                 ← Generic single for all CPTs
├── single-ilbs_member.php     ← Member profile
├── archive-ilbs_member.php    ← Alumni directory
├── archive-ilbs_reunion.php   ← Reunions listing
├── archive-ilbs_award.php     ← Awards listing
├── archive-ilbs_publication.php ← Publications listing
├── archive-ilbs_lecture.php   ← Lecture series
├── archive-ilbs_gallery.php   ← Photo gallery
├── archive-ilbs_video.php     ← Video library
├── archive-ilbs_news.php      ← News & announcements
├── template-parts/
│   ├── header.php             ← Reusable header HTML
│   ├── footer.php             ← Reusable footer HTML
│   └── member-card.php        ← Member card partial (AJAX)
├── assets/
│   └── js/
│       └── ilbs-main.js       ← Dark mode, sliders, counters, search
└── acf-json/
    ├── group_ilbs_member_fields.json
    ├── group_ilbs_event_fields.json
    ├── group_ilbs_award_fields.json
    ├── group_ilbs_publication_fields.json
    └── group_ilbs_lecture_fields.json
```

---

## 🚀 Installation

### 1. Prerequisites
- WordPress 6.4+
- Twenty Twenty-One parent theme installed and active
- **Advanced Custom Fields (ACF)** free or Pro — for all custom field groups
- *(Optional)* Contact Form 7 — for the contact page form

### 2. Upload the Theme
1. Zip the `ilbs-alumni-child-theme/` folder.
2. Go to **WordPress Admin → Appearance → Themes → Add New → Upload Theme**.
3. Upload the ZIP and click **Activate**.
4. Visit **Settings → Permalinks** and click **Save Changes** to flush rewrite rules.

### 3. Upload Banner Images
Copy the banner images from the original prototype's `/public/banners/` folder into:
```
wp-content/themes/ilbs-alumni-child-theme/assets/images/banners/
```
Required files:
- `ilbs-campus-banner.jpg`
- `convocation-lamp.jpg`
- `academic-procession.jpg`
- `convocation-stage.jpg`
- `alumni-ceremony.jpg`

### 4. ACF Field Groups
If you have ACF installed, field groups will load automatically from the `acf-json/` folder.
Go to **Custom Fields → Tools → Sync** to import them.

### 5. Create Required Pages
Create these pages in **Pages → Add New** and assign their templates:

| Page Title              | Slug                   | Template         |
|-------------------------|------------------------|------------------|
| About                   | `about`                | About            |
| Contact                 | `contact`              | Contact          |
| Leadership              | `leadership`           | (default)        |
| Executive Committee     | `committee`            | (default)        |
| Chancellor Message      | `chancellor-message`   | (default)        |
| Vice Chancellor Message | `vice-chancellor-message` | (default)     |
| Privacy Policy          | `privacy-policy`       | (default)        |
| Terms & Conditions      | `terms`                | (default)        |

### 6. Set Homepage
Go to **Settings → Reading** and set:
- Your homepage displays: **A static page**
- Homepage: select any page (the `front-page.php` template overrides it)

### 7. Navigation Menu
Go to **Appearance → Menus**. The header uses a custom walker — the mega menu
structure is hardcoded in `template-parts/header.php` and uses WordPress URL functions,
so no menu setup is needed for the main nav. However, you can register optional menus
for footer columns if desired.

---

## 🎨 Customisation

### Colours / Design Tokens
All colours are in `style.css` under `:root { }`. Edit:
```css
--primary:   #0056d6;   /* Main blue */
--secondary: #0a1f44;   /* Dark navy */
--accent:    #f4b400;   /* Gold/yellow */
```

### Dark Mode
Toggled by the moon/sun button in the header. Theme persists in `localStorage` as `ilbs-theme`.

### Stats Counter
Edit the numbers in `front-page.php`:
```php
<strong data-counter="100">0</strong><span>Alumni Members</span>
```
Or add an ACF Options page to make them editable from the admin.

### Banner Slides
The 5 banner slides are defined as an array in `front-page.php`. To make them editable
from the admin, add an ACF Flexible Content or Repeater field on an Options page.

---

## 📦 Custom Post Types & ACF Fields

| CPT | Slug | Key ACF Fields |
|-----|------|----------------|
| `ilbs_member` | `/members/` | batch, specialization, profession, organization, location_text, email, phone, linkedin, orcid, achievements, research, publications, awards |
| `ilbs_event` | `/events/` | event_type, start_date, end_date, venue, agenda, registration_url, speakers |
| `ilbs_reunion` | `/reunions/` | start_date, end_date, venue, agenda, registration_url |
| `ilbs_award` | `/awards/` | award_year, category, recipient_member, citation |
| `ilbs_publication` | `/publications/` | publication_type, authors, journal, year, abstract, pdf_file, doi |
| `ilbs_lecture` | `/lectures/` | speaker, lecture_date, video_url, presentation_pdf, transcript |
| `ilbs_news` | `/news/` | (uses post date + excerpt) |
| `ilbs_gallery` | `/galleries/` | (uses featured image) |
| `ilbs_video` | `/videos/` | video_url, duration, speaker |

---

## 🔌 Recommended Plugins

| Plugin | Purpose |
|--------|---------|
| **Advanced Custom Fields** | All custom fields (mandatory) |
| **Contact Form 7** | Contact page form |
| **Yoast SEO / RankMath** | SEO optimisation |
| **MailChimp for WP (MC4WP)** | Newsletter subscription |
| **WP Super Cache / W3 Total Cache** | Performance |
| **Smush / ShortPixel** | Image optimisation |

---

## 💡 Notes

- All templates degrade gracefully — if ACF is not installed, fields return empty strings and static fallback content is shown.
- The AJAX member directory filter (`ilbs_filter_members`) is secured with a WordPress nonce.
- Bootstrap 5, Swiper 11, and AOS are loaded from CDN. For production, consider self-hosting or using a build tool.
- The theme suppresses Twenty Twenty-One's default header/footer and replaces them with custom ones.

---

*Built for the ILBS Alumni Association — Institute of Liver & Biliary Sciences, New Delhi.*
