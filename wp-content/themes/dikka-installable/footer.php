<?php // Exit if accessed directly
wp_enqueue_style('facebox-css', get_template_directory_uri().'/assets/css/facebox.css');
wp_enqueue_script('facebox', get_template_directory_uri().'/assets/js/facebox.js', array(), FALSE, TRUE);
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

        </div>
<?php  global $dikka_options; ?>

       <div class="footer" <?php if(isset($dikka_options['footer-on']) && $dikka_options['footer-on']!=1) echo 'style="display:none;"';?>>
            <!-- BEGIN BOTTOM FOOTER -->
            <div class="container">
                <?php get_template_part('partials/footer-layout'); ?>

            </div>

            <p id="back-top"><a href="#home"><i class="fa fa-angle-up"></i></a></p>
       </div>

       <div id="bottom-footer" class="text-center" <?php if(isset($dikka_options['secondfooter-on']) && $dikka_options['secondfooter-on']!=1) echo 'style="display:none;"';?> >

       		<div class="container">
	            <?php if(isset($dikka_options['footer-logo']['url']) && $dikka_options['footer-logo']['url']!='') :  ?>
	            <!-- BEGIN: LOGO FOOTER -->
	            <div class="logo-footer">
	                 <img src="<?php echo esc_url($dikka_options['footer-logo']['url']); ?>" data-at2x="<?php echo esc_url($dikka_options['footer-retinalogo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />

	                 <ul class="contacts-footer">
	                 	<?php if(isset($dikka_options['footer-address']) && $dikka_options['footer-address']!='') :  ?>
	                 	<li><i class="fa fa-map-marker"></i> <?php echo esc_attr($dikka_options['footer-address']); ?></li>
	                    <?php endif; ?>
	                    <?php if(isset($dikka_options['footer-email']) && $dikka_options['footer-email']!='') :  ?>
	                 	<li><i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo esc_attr($dikka_options['footer-email']); ?>"><?php echo esc_attr($dikka_options['footer-email']); ?></a></li>
	                    <?php endif; ?>
	                    <?php if(isset($dikka_options['footer-phone']) && $dikka_options['footer-phone']!='') :  ?>
	                 	<li><i class="fa fa-phone"></i> <?php echo esc_attr($dikka_options['footer-phone']); ?></li>
	                    <?php endif; ?>
	                 </ul>

	            </div>
	            <?php endif; ?>
	              <?php if (isset($dikka_options['footer-social']) && $dikka_options['footer-social']==1) : ?>
	            <!-- BEGIN: ICONS FOOTER -->
	            <div class="socialdiv colored">
	                <ul>
	                    <?php if (!empty($dikka_options['social_facebook'])) : ?>
	                    <li><a class="facebook" href="<?php  echo esc_url($dikka_options['social_facebook']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_twitter'])) : ?>
	                    <li><a class="twitter" href="<?php  echo esc_url($dikka_options['social_twitter']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_googlep'])) : ?>
	                    <li><a class="google" href="<?php  echo esc_url($dikka_options['social_googlep']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_youtube'])) : ?>
	                    <li><a class="youtube" href="<?php  echo esc_url($dikka_options['social_youtube']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_linkedin'])) : ?>
	                    <li><a class="linkedin" href="<?php  echo esc_url($dikka_options['social_linkedin']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_pinterest'])) : ?>
	                    <li><a class="pinterest" href="<?php  echo esc_url($dikka_options['social_pinterest']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_dribbble'])) : ?>
	                    <li><a class="dribbble" href="<?php  echo esc_url($dikka_options['social_dribbble']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_skype'])) : ?>
	                    <li><a class="skype" href="<?php  echo esc_url($dikka_options['social_skype']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_vimeo'])) : ?>
	                    <li><a class="vimeo" href="<?php  echo esc_url($dikka_options['social_vimeo']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_tumblr'])) : ?>
	                    <li><a class="tumblr" href="<?php  echo esc_url($dikka_options['social_tumblr']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>


	                    <?php if (!empty($dikka_options['social_instagram'])) : ?>
	                    <li><a class="instagram" href="<?php  echo esc_url($dikka_options['social_instagram']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                    <?php if (!empty($dikka_options['social_yelp'])) : ?>
	                    <li><a class="yelp" href="<?php  echo esc_url($dikka_options['social_yelp']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                    <?php if (!empty($dikka_options['social_behance'])) : ?>
	                    <li><a class="behance" href="<?php  echo esc_url($dikka_options['social_behance']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                    <?php if (!empty($dikka_options['social_flickr'])) : ?>
	                    <li><a class="flickr" href="<?php  echo esc_url($dikka_options['social_flickr']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                </ul>
	            </div>
	            <?php endif; ?>
	            <?php if(isset($dikka_options['footer_text'])) :  ?>
	            <!-- BEGIN: COPYRIGHTS -->
	            <div class="b-text">
	                <p><?php  echo wp_kses_post($dikka_options['footer_text']); ?></p>
	            </div>
	            <?php endif; ?>
	        </div>
	        <!-- END CONTAINER -->
	    </div><!-- END BOTTOM FOOTER -->

    </div>
    <!-- Don't forget analytics -->
    <?php if(isset($dikka_options['meta_javascript']) && $dikka_options['meta_javascript']!='')
    echo $dikka_options['meta_javascript']; ?>
    <?php wp_footer(); ?>
<div class="for-popup">
    <div id="lead_sample" style="display:none;">
        <div class="popup-inner-cont">

            <div class="p-heading-pop">About Us</div>
            <div class="p-text-pop">
                <p> For years, Info-investments.com has provided objective, unbiased annuity information to consumers
                    interested in making the right choices with their retirement savings. We do NOT sell annuities or any
                    other financial products or services, and we are NOT affiliated with any other company. Our job is to
                    answer questions on as wide a range of annuity topics as possible, and provide free annuity quotes to
                    consumers who feel an annuity might be the right fit for them.
                </p>

            </div>

        </div>

    </div>
    <div id="about_us_PopUP" style="display:none;">
        <div class="popup-inner-cont">

            <div class="p-heading-pop">About Us</div>
            <div class="p-text-pop">
                <p> Financialize.com is a marketing technology company designed specifically to help Financial
Professionals source and purchase leads. We provide the traditional method of lead purchase as
well as an auction platform that allows advisors and agents to create territories from which they
would want to receive lead alerts, and an auction process that allows them to place bids on those
leads they wish to target.
<br/>
We have a combined 25+ years experience in generating high-quality financial leads, and we
work with some of the biggest brands both online & offline.
<br/>
One of our core value propositions is that we control the lead process from A to Z, including
owning and operating our own call center. As a result, we leave nothing to chance and can
ensure that all aspects of lead quality can be closely monitored.
<br/>Financialize.com a privately held Limited Liability Company registered in Delaware.
For more information, please <a href="#">contact us.</a>
                </p>

            </div>

        </div>

    </div>
    <div id="term_of_use_PopUP" style="display:none;">
        <div class="popup-inner-cont">

            <div class="p-heading-pop">Terms of Use</div>
            <div class="p-text-pop">


<p>In this document “www.Financialize.com.” or “we” refers to www.Financialize.com. and www.Financialize.com., Inc. Instances of the word “you” refer to a visitor to this website who, by using our online services, agrees to these terms of use. You should read through all the Terms carefully. The Terms constitute a legally binding agreement between you and www.Financialize.com., Inc. a Delaware corporation that is the owner of the Site. You agree that your use of the Site, including provision or use of any Content, does not violate any applicable law.
</p>

<p>www.Financialize.com. does not offer individual investment advice. This site is published with the understanding that the publisher is not engaged in rendering legal, tax, or investment services. Since each individual’s situation is unique, a qualified professional should be consulted before making financial decisions.
</p>
<p>
<p>The information is provided on an “as is” basis. We make no guarantees as to the accuracy, thoroughness or quality of the information, and are not responsible for errors or omissions. The information provided at this site is neither comprehensive nor appropriate for every individual. Some of the information is relevant only in Canada or the U.S., and may differ elsewhere. Some of the site content and linked sites relate to subjects or investment strategies that might not be appropriate for some individuals. You are strongly cautioned to verify any information before using it for any personal, financial or business purpose. This site is provided on the express condition, to which all making use thereof assent, that no liability shall be incurred by www.Financialize.com., www.Financialize.com., Inc. or any of its employees.
</p>
<p>
<p>You also understand that www.Financialize.com. cannot and does not guarantee or warrant that files available for downloading through the site will be free of infection or viruses or other code that manifest contaminating or destructive properties. You are responsible for implementing sufficient procedures and checkpoints to satisfy your particular requirements for accuracy of data input and output, and for maintaining a means external to the site for the reconstruction of any lost data.
</p>
<p>
When you use the Site to send an information request to us, you agree to allow the Site to add your e-mail address to our database of contacts. Please review our Privacy Policy for more information regarding our information collection practices and safeguards, and how to opt not to receive e-mails. Your use of the Site signifies your acknowledgement of and agreement with our Privacy Policy, which is expressly incorporated into these Terms.
</p>
<p>
In no event will www.Financialize.com. be liable for (i) any incidental, consequential, or indirect damages including, but not limited to, damages for loss of profits, business interruption, loss of programs or information, etc. arising out of the use of or inability to use the service, or any information or transactions provided on the service, or downloaded from the service, or any delay of such information or service. Even if www.Financialize.com. or its authorized representatives have been advised of the possibility of such damages, or (ii) any claim attributable to errors, omissions, or other inaccuracies in the service and/or materials or information downloaded through the service. Because some countries do not allow the exclusion or limitation of liability for consequential or incidental damages, the above limitation may not apply to you. In such countries, www.Financialize.com.’s liability is limited to the greatest extent permitted by law.
</p>
<p>
All Content on the Site, and the Site itself, is protected by copyright and you will abide by any and all additional copyright notices, information, or restrictions contained in or relating to any Content on the Site. Copying or storing of any Content other than for your personal, noncommercial use is expressly prohibited without the prior written permission from us or the applicable copyright holder.
</p>
<p>
We may change, suspend or discontinue any aspect of the Site at any time, including the availability of any Site features, database, or Content. We may also impose limits on certain features or services or restrict your access to parts or all of the Site without notice to you or liability to us.
</p>
<p>
This Site may contain links and pointers to other Internet sites. Links to and from the Site to other sites, maintained by third parties, do not constitute an endorsement by us of such third-party sites or the contents thereof.
</p>
<p>
We do not separately file the Terms entered into by each user of the Site. Please make a copy of these Terms for your records by printing and/or saving a downloaded copy of the Terms on your personal computer.
</p>

We may immediately and in our sole discretion terminate any user’s access to or use of the Site due to such user’s breach of these Terms, our Privacy Policy or other unauthorized use of the Site.
</p>

If you are aware of or experience any Content, activity or communication through or in connection with the Site that appears to be in violation of the above, or in violation of any other provision of these Terms, we ask that you please contact and inform us of any such violations; Contact Us.
</p>
<p>
This agreement shall all be governed and construed in accordance with the laws of Delaware in the United States of America. By using our website, you consent to the agreement as specified above.
</p>


            </div>
        </div>

    </div>
    <div id="privacy_policy_PopUP" style="display:none;">
        <div class="popup-inner-cont">

            <div class="p-heading-pop">Privacy Policy</div>
            <div class="p-text-pop">
               <p>
Financialize has created this Privacy Policy to demonstrate our firm commitment to privacy. The following discloses our information gathering and dissemination practices for the website www.Financialize.com.
</p>
<p>
<strong>SECURE SITE</strong><br/>
Our site uses an online secure form for customer applications. When your request is placed through our secure online server we collect confidential customer information which our secure server software (SSL) encrypts before it is sent to us. All of the customer data we collect is protected against unauthorized access.
</p>
<p>
<strong>PERSONALLY IDENTIFIABLE INFORMATION</strong><br/>
Our participating financial professionals, to whom this information is referred, are bound by the same terms of confidentiality, and use such information to contact the customers for purposes of providing customers with the requested information.
</p>
<p>
<strong>DISCLOSURE TO OUTSIDE PARTIES</strong><br/>
Aggregate statistics about our customers, sales, traffic patterns and related site information may be provided to reputable third parties, which will not contain personally identifying or financial information. Financialize.com may release account information when we believe, in good faith, that such release is reasonably necessary to comply with the law, enforce the terms of any of our user agreements or protect the rights, property or safety of Financialize.com, our customers or others.
</p>
<p>
<strong>USE OF INFORMATION</strong><br/>
By submitting your information via our website, you acknowledge and agree that we may contact you to discuss our lead generation and auction programs.
</p>
<p>
<strong>COOKIES</strong><br/>
We use outside companies to display ads on our site. These ads may contain pieces of information that a website transfers to a hard drive for record keeping purposes while at the site.
</p>
<p>
<strong>PERSONS UNDER 18</strong><br/>
We have no way of distinguishing the age of individuals who access our website; however, in the event that we discover that a person under the age of 18 is providing personally-identifying information, we will not accept any such information. If a person had provided us with personally-identifying information without parental or guardian consent, the parent or guardian should contact us to remove that information and opt out of promotional opportunities.
</p>
<p>
<strong>YOUR CONSENT</strong><br/>
By using our site, you consent to the collection and use of this information by Financialize.com. If we decide to change our privacy policy, we will post those changes on this page so that you are always aware of what information we collect, how we use it and under what circumstances we may disclose it.
</p>
            </div>

        </div>

    </div>
    <div id="contact_us_PopUP" style="display:none;">
        <div class="popup-inner-cont">

            <div class="p-heading-pop">Contact Us</div>
            <div class="p-text-pop"><p>Contact us about any questions you may have about our site, or products, and our
                    company. Our toll free number is (888) 390-4132, or you can email us at: info@Info-investments.com .</p>
            </div>
        </div>

    </div>
</div>
    </body>
</html>
<script>
    function pop_ups(id) {
        jQuery.facebox(jQuery('#' + id).html());
        //jQuery.facebox(document.getElementById(id).innerHTML);
    }
    jQuery('.lead-sample').click(function () {view_sample();});
    function view_sample(){

       var html = '<div id="basic-modal-content"  class="lead_Auction_PopupContent">';
        html +='<div class="box-content mLeftRight">';
        html +='<div>';
        html +='<div style="width:100%;">';
        html +='<h3 class="center" style=" color: #3A3A3A;"><b>Lead Auction:</b><span> #125325</span></h3>';
        html +='<b>Auction ends:</b> <span>12:45 PM (Tuesday, March 18th)</span><br />';
        html +='<b>Opening Bid: </b> <b class="popP redish">$75</b>';
        html +='</div>';
        html +='<div class="popDivBorder"></div>';
        html +='<div class="popDiv paddingTop10">';
        html +='<div class="leftPop"><b>Lead Type:</b></div>';
        html +='<div class="rightPop"> <p class="popP">Phone Qualified</p>';
        html +='<p  class="popP">Our Call center has qualified this lead by phone, and has confirmed the leads interest in speaking with financial Professional.</p></div>';
        html +='</div>';
        html +='<div class="popDiv paddingTop10">';
        html +='<div class="leftPop"><b>City, State:</b></div>';
        html +='<div class="rightPop"><p class="popP">Grove Hill, AL 36451';
        html +='</p></div>';
        html +='</div>';
        html +='<div class="popDiv paddingTop10">';
        html +='<div class="leftPop"><b>Age:</b></div>';
        html +='<div class="rightPop"><p class="popP">63 Year Old</p></div>';
        html +='</div>';
        html +='<div class="popDiv paddingTop10">';
        html +='<div class="leftPop"><b>Retirement Saving:</b></div>';
        html +='<div class="rightPop"><p class="popP">$ 150,000 to $250,000</p></div>';
        html +='</div>';
        html +='<div class="popDiv paddingTop10">';
        html +='<div class="leftPop"><b>Specific Interests:</b></div>';
        html +='<div class="rightPop"><p class="popP">Retirement Planning</p></div>';
        html +='</div>';
        html +='<div class="popDiv paddingTop10">';
        html +='<div class="leftPop"><b>Notes from our call:</b></div>';
        html +='<div class="rightPop"><p class="popP">John has $175,000 in his 401(k). He left his company about 6 month ago, and wants to roll his retirement saving into something that will help guarantee him monthly income when he retires. He is 63, and hopes to be retireng in about 5 year.He and his wife have several IRAs as well.John has many question, and says the advisor can call anytime starting at about 3:00pm, as that is when he normally gets home.</p></div>';
        html +='</div>';
        html +='<div class="popDiv paddingTop10">';
        html +='<div class="leftPop"><b></b></div>';
        html +='<div class="rightPop SNleftalign"><a class="btnMargin largebtn-makebid"></a></div>';
        html +='</div>';
        html +='</div>';
        html +='</div>';
        html +='</div>';
        jQuery.facebox(html);
    }

 jQuery(function () {
     // Our Leads Section Hide Show Start from here
    jQuery('.first-tab').click(function () {
        if (jQuery('.first-col-open').css('display') == 'none') {
            jQuery('.first-col-open').show();
            jQuery(".first-tab").addClass("active");
        } else {
            jQuery('.first-col-open').hide();
            jQuery(".first-tab").removeClass("active");
        }
        jQuery('.second-col-open').hide();
        jQuery('.Third-col-open').hide();
        jQuery(".second-tab").removeClass("active");
        jQuery(".third-tab").removeClass("active");
    });
    jQuery('.second-tab').click(function () {
        if (jQuery('.second-col-open').css('display') == 'none') {
            jQuery('.second-col-open').show();
            jQuery(".second-tab").addClass("active");
        } else {
            jQuery('.second-col-open').hide();
            jQuery(".second-tab").removeClass("active");
        }
        jQuery('.first-col-open').hide();
        jQuery('.Third-col-open').hide();
        jQuery(".first-tab").removeClass("active");
        jQuery(".third-tab").removeClass("active");
    });
    jQuery('.third-tab').click(function () {
        if (jQuery('.Third-col-open').css('display') == 'none') {
            jQuery(".third-tab").addClass("active");
            jQuery('.Third-col-open').show();
        } else {
            jQuery(".third-tab").removeClass("active");
            jQuery('.Third-col-open').hide();
        }
        jQuery('.first-col-open').hide();
        jQuery('.second-col-open').hide();
        jQuery(".second-tab").removeClass("active");
        jQuery(".first-tab").removeClass("active");
    });
     // Our Leads Section Hide Show End here

     jQuery('.left-colbox2').click(function () {
         if (jQuery('.first-col-show').css('display') == 'none') {
             jQuery(".left-colbox2 a").addClass("active");
             jQuery('.first-col-show').show();
         } else {
             jQuery(".left-colbox2 a").removeClass("active");
             jQuery('.first-col-show').hide();
         }
         jQuery('.second-col-show').hide();
         jQuery(".rightbox2 a").removeClass("active");
     });
     jQuery('.rightbox2').click(function () {
         if (jQuery('.second-col-show').css('display') == 'none') {
             jQuery('.second-col-show').show();
             jQuery(".rightbox2 a").addClass("active");
         } else {
             jQuery('.second-col-show').hide();
             jQuery(".rightbox2 a").removeClass("active");
         }
         jQuery('.first-col-show').hide();
         jQuery(".left-colbox2 a").removeClass("active");
     });
 });

    function contactUsForm(){
        var html = '<div id="basic-content"  class="lead_Auction_PopupContent popup-inner-cont">';
        html +='<h3 class="center childHeadingM">Contact Us</h3>';
        html +='<div class="faqMargin">';
        html +='<p>We welcome your comments, questions or feedback. Please use the form below and we will respond as quickly as we can, normally within 24 hours or one business day.</p>';
        html +='<div id="form_cnt">';
        html +='<form id="contact_us_form">';
        html +='<input type="hidden" name="contact_us_form" value="1">';
        html +='<table cellspacing="5" class="left">';
        html +='<tbody>';
        html +='<tr>';
        html +='<th colspan="2"><span class="val-err"> Validation Errors! </span></th>';
        html +='</tr>';
        html +='<tr>';
        html +='<th><span> First Name: </span></th>';
        html +='<th><input type="text" name="first_name" id="form_first_name" placeholder="First Name" onfocus="classRemove(this.id)"><br></th>';
        html +='</tr>';
        html +='<tr>';
        html +='<th><span>Last name: </span></th>';
        html +='<th><input type="text" name="last_name" id="form_last_name" placeholder="Last Name" onfocus="classRemove(this.id)"><br></th>';
        html +='</tr>';
        html +='<tr>';
        html +='<th><span>Zip Code:</span></th>';
        html +='<th><input type="text" name="zip_code" id="form_zip_code" placeholder="Zip Code" onfocus="classRemove(this.id)"><br></th>';
        html +='</tr>';
        html +='<tr>';
        html +='<th><span>Phone: </span></th>';
        html +='<th><input type="text" name="phone" id="form_phone" placeholder="Phone" onfocus="classRemove(this.id)"><br></th>';
        html +='</tr>';
        html +='<tr>';
        html +='<th><span>Email: </span></th>';
        html +='<th><input type="text" name="email" id="form_email" placeholder="Email Address" onfocus="classRemove(this.id)"><br></th>';
        html +='</tr>';
        html +='<tr>';
        html +='<th><span>Type of Practice: </span></th>';
        html +='<th><select class="contactSelection cntctS320" name="type_of_practice" id="form_type_of_practice" onfocus="classRemove(this.id)">';
        html +='<option value="">Select One</option>';
        html +='<option value="Registered Investment Advisor">Registered Investment Advisor</option>';
        html +='<option value="Investment Advisor">Investment Advisor</option>';
        html +='<option value="Wealth Advisor">Wealth Advisor</option>';
        html +='<option value="Insurance Agent">Insurance Agent</option>';
        html +='<option value="Other">Other</option>';
        html +='</select> <br></th>';
        html +='</tr>';
        html +='<tr>';
        html +='<th><span>Questions / Comments: </span></th>';
        html +='<th><textarea rows="4" cols="50" name="question" id="form_question" placeholder="Questions / Comments" onfocus="classRemove(this.id)"> </textarea><br></th>';
        html +='</tr>';
        html +='<tr>';
        html +='<th></th>';
        html +='<th><a href="javascript:void(0)" onclick="validate_contact_us()" class="largebtn-submit"></a></th>';
        html +='</tr>';
        html +='</tbody>';
        html +='</table>';
        html +='</form>';
        html +='</div>';
        html +='</div>';
        html +='</div>';
        jQuery.facebox(html);
    }
    function validate_contact_us()
    {
        var error_msg='';
        if(jQuery.trim(jQuery("#form_first_name").val()) == '')
        {
            error_msg+='Please enter the First Name.\n';
            jQuery("#form_first_name").addClass("err_cls");
        }
        if(jQuery.trim(jQuery("#form_last_name").val()) == '')
        {
            error_msg+='Please enter the Last Name.\n';
            jQuery("#form_last_name").addClass("err_cls");
        }
        if(jQuery.trim(jQuery("#form_zip_code").val()) == '')
        {
            error_msg+='Please enter the ZIP.\n';
            jQuery("#form_zip_code").addClass("err_cls");
        }
        if(jQuery.trim(jQuery("#form_phone").val()) == '')
        {
            error_msg+='Please enter the Phone.\n';
            jQuery("#form_phone").addClass("err_cls");
        }
        if(jQuery.trim(jQuery("#form_email").val()) == '')
        {
            error_msg+='Please enter the Email.\n';
            jQuery("#form_email").addClass("err_cls");

        }
        if(!isValidEmailAddress(jQuery.trim(jQuery("#form_email").val()))){
            error_msg+='Please enter the Valid Email.\n';
            jQuery("#form_email").addClass("err_cls");
        }
        if(jQuery.trim(jQuery("#form_type_of_practice").val()) == '')
        {
            error_msg+='Please select a type of Practice.\n';
            jQuery("#form_type_of_practice").addClass("err_cls");
        }
        if(jQuery.trim(jQuery("#form_question").val()) == '')
        {
            error_msg+='Please enter the Questions/Comments.\n';
            jQuery("#form_question").addClass("err_cls");

        }
        if(error_msg!=''){
            jQuery('#contact_us_form span.val-err').show();
            return false;
        }else{
            jQuery('#contact_us_form span.val-err').hide();
            jQuery("#form_first_name").removeClass("err_cls");
            jQuery("#form_last_name").removeClass("err_cls");
            jQuery("#form_zip_code").removeClass("err_cls");
            jQuery("#form_phone").removeClass("err_cls");
            jQuery("#form_email").removeClass("err_cls");
            jQuery("#form_type_of_practice").removeClass("active");
            jQuery("#form_question").removeClass("err_cls");
        }
        jQuery.ajax({
            type: "POST",
            url: "https://admin.financialize.com/api/contact_us_request.php",
            data: jQuery('#contact_us_form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.status == 'success') {
                        jQuery('#form_cnt').html(data.html);
                }
                else
                   alert('error');
            }
        });
    }
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
        return pattern.test(emailAddress);
    }
function classRemove(id){
    jQuery("#"+id).removeClass("err_cls");
}
jQuery(document).ready(function(){
  jQuery('.t-author p a').attr('target', '_blank');
});
</script>

<script>
jQuery('style#rs-plugin-settings-inline-css').remove();
</script>
