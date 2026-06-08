<?php
/**
 * Template Name: ILBS — Contact
 * Template Post Type: page
 *
 * Maps to: pages/contact.html
 */
get_header();
?>

<main>
   <section class="page-hero">
      <div class="container">
         <span class="eyebrow text-warning">Contact</span>
         <h1>Alumni Office</h1>
         <p class="lead">Office details, map, support form, feedback form and social links.</p>
      </div>
   </section>
   <section class="section">
      <div class="container">
         <div class="row g-4">
            <div class="col-lg-6">
               <div class="content-card">
                  <h3>Support Form</h3>
                  <form class="row g-3">
                     <div class="col-md-6"><input class="form-control" placeholder="Full name"></div>
                     <div class="col-md-6"><input class="form-control" placeholder="Email"></div>
                     <div class="col-12">
                        <select class="form-select">
                           <option>Membership support</option>
                           <option>Event support</option>
                           <option>Publication submission</option>
                           <option>Feedback</option>
                        </select>
                     </div>
                     <div class="col-12"><textarea class="form-control" rows="5" placeholder="Message"></textarea></div>
                     <div class="col-12"><button class="btn btn-primary">Send Message</button></div>
                  </form>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="content-card">
                  <h3>Office Details</h3>
                  <p>Institute of Liver & Biliary Sciences<br>D-1, Vasant Kunj, New Delhi - 110070</p>
                  <p>alumni@ilbs.in<br>+91 11 4630 0000</p>
                  <div style="height:240px;border-radius:8px;background:linear-gradient(135deg,var(--primary),var(--secondary));display:grid;place-items:center;color:#fff;font-weight:900;">Map Embed</div>
                  <div class="socials mt-3"><a href="#"><i class="bi bi-linkedin"></i></a><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-youtube"></i></a></div>
               </div>
            </div>
         </div>
      </div>
   </section>
</main>

<?php get_footer(); ?>
