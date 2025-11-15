<?php

use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\PrivacyPolicy;

class FrontendPageDesignAdd extends Migration
{
    public function up()
    {
        $privacy = PrivacyPolicy::first();
        $frontend = FrontPage::where('slug', '/privacy')->first();
        $frontend->title = $privacy->page_banner_title;
        $frontend->sub_title = $privacy->page_banner_sub_title;
        $frontend->banner = $privacy->page_banner;
        $frontend->details = $this->container($privacy->details, $privacy->page_banner_title, $privacy->page_banner_sub_title);
        $frontend->save();
    }




    public function container($details, $title = '', $subtitle = '')
    {
        $imagePath = asset('public/frontend/infixlmstheme/img/new_bread_crumb_bg.png');

        $html = "
    <div class='row'>
        <div class='col-sm-12 ui-resizable' data-type='container-content'>

            <div class='breadcrumb_area' style='background-image: url(".$imagePath.");'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='breadcam_wrap'>
                                <h4>".$title." </h4>
                                 <p>". __('frontend.Home')." / ".$subtitle." </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-sm-12 ui-resizable' data-type='container-content'>
            <div class='courses_area'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-12'>
<div class='bg-white p-4 shadow-sm rounded'>
             <h4 class='mt-4'>Introduction</h4>
<p>This privacy policy explains how <b>InfixLMS APP</b>  use and protect the information we hold, whether it relates to the Educational Institution, students, parents, its staff and third party service providers in connection with our business and has been developed . This privacy policy does not require any physical, electronic or digital signature. We are committed to maintaining the privacy of our students, parents, teachers and other users of our website/application.</p>
<br>
<p>This privacy policy governs your use of the application <b>InfixLMS APP</b>. By entering to this Website or downloading the app via Play Store /App Store you agree to be bound by the terms and conditions of this Privacy Policy. If you do not agree, please do not use or access our website/application. By mere use of the website/application, you expressly consent to our use and disclosure of your personal information in accordance with this Privacy Policy. It is incorporated into and subject to the Terms and Conditions.</p>
<br>
<p>Please read this privacy policy (‘Policy’) carefully before using the Application, Website and our services along with the Terms and Conditions (‘TaC’) provided on the Application and the Website. Your use of the Website, Application, or  services in connection with the Application or Website (‘Services’), or registrations with us through any modes or usage of any products shall signify your acceptance of this Policy and your agreement to be legally bound by the same. </p>
 <p>We may change this Privacy Policy from time to time. If we make changes, we will notify you by revising the date at the top of this policy, and in some cases, we may provide you with additional notice (such as adding a statement to the homepages of our websites/applications or sending you an email notification). We encourage you to review the Privacy Policy whenever you interact with us to stay informed about our information practices and the ways you can help protect your privacy.</p>

            <h4 class='mt-4'>Definition of Needed Information</h4>
<p>Needed information means information about an educational institute or identifiable individual or information that permits an individual to be identified. </p>
            <h4 class='mt-4'>Collection of Information</h4>
            <p><b>InfixLMS APP</b> is a smart software service, it takes responsibility for maintaining and protecting the personal information under our control.</p>
            <h4 class='mt-3'>User Provided Information</h4>
            <p>The Application/Website/Services obtains the information you provide when you download and register for the Application or Services. When the educational institution register with us, generally has to provide (a) Name of the Institution, Registration number, Address,  School Landline Phone Number (for verification), Contact Person’s Name, position and mobile number, School website, email and password (b) transactions related information, such as when you make download or use application from us; (c) information you provide us when you contact us for help; (d) information you enter into our system when using the Application/Services, such as while asking doubts, participating in discussions and taking tests: (f) information of the users of the Application such as students/parents, teachers and other staff.</p>
<br><p>It is possible to register the individuals (Teachers, Parents/students or Assistants) in the applications, only after the School/Institution is registered with <b>InfixLMS APP</b> . As registration is requested, Users agree to provide accurate and complete registration information. At the time of registration Users may be required to provide  information which includes your name, address, phone number, and email address collectively referred as “User profile content “ User upon registration.</p>
<br><p>We only collect personal information as required to meet the purposes that we have identified. We do not indiscriminately collect or retain personal information. Our reason for collecting personal information about teachers, students, parents and staff is to establish and maintain communication with that individual.</p>
<br><p>We will not differentiate between who is using the device to access the Application, Website or Services or products, so long as the log in/access credentials match with yours. In order to make the best use of the Application/Website/Services/products and enable your Information to be captured accurately on the Application/Website/Services it is essential that you have logged in using your own credentials.</p>
<br><p>Users shall take reasonable precautions to protect against theft, loss or fraudulent use of such IDs and passwords, and Users are solely responsible for any losses arising from another party’s use of such IDs and passwords, either with or without User’s knowledge. </p>

            <h4 class='mt-3'>Automatically Collected Information</h4>
            <p>In addition, the Application/products/Services may collect certain information automatically, including, but not limited to, the type of mobile device you use, your mobile operating system, and information about the way you use the Application/Services. As is true of most Mobile applications, we also collect other relevant information as per the permissions that you provide.</p>

            <h4 class='mt-4'>Provide Service</h4>
            <p>To personalize user experience we may use information. We continually strive to improve our website/Application offerings based on the information and feedback we receive from you.  The User can completely customize our service web or application.</p>

            <h4 class='mt-4'>Contacting and Customer Service</h4>
            <p>You will be contacted as necessary to enforce our User Agreement, applicable national laws, and any agreement we may have with you. It will help us contact you to notify you regarding your account, to troubleshoot problems with your account, to resolve a dispute, as otherwise necessary to provide you customer service.
For these purposes we may contact you via email, telephone, text messages, WhatsApp messages and postal mail. When contacting you via telephone, to ensure efficiency, we may use autodialer or pre-recorded calls and text messages.</p>

            <h4 class='mt-4'>Prevent Fraudulent and Illegal Activities</h4>
            <p>We preserve your personal information as long as it is necessary and relevant for our operations. In addition, we may retain personal information from closed accounts to comply with national laws, prevent fraud, collect any fees owed, resolve disputes, troubleshoot problems, assist with any investigation, enforce our User Agreement and take other actions permitted or required by applicable national laws. After it is no longer necessary for us to retain your personal information, we dispose of it in a secure manner according to our data retention and deletion policies.
It will help us prevent, detect, mitigate, and investigate fraud, security breaches, potentially prohibited or illegal activities. It will also be used to enforce our Privacy Notice, our User Agreement or other policies.
</p>

            <h4 class='mt-4'>To Personalize the Advertising and Marketing Communications</h4>
            <p>We will use the contact information you have provided to contact you by e-mail, SMS text, WhatsApp Messages and/or telephone to deliver targeted marketing, service updates, and promotional offers based on your communication preferences. To personalize, measure, and improve our advertising based on your advertising customization preferences we will use your institutional/personal data (such as School administrators, Principals or other responsible persons) to address you. We will also contact you, in ways such way of email, telephone, text messages, via WhatsApp or postal mail, so as to keep you informed about our offers, and promotions, as well as to inform you about our services, and those of our organization , with a view to facilitate our mission of imparting education. </p>

            <h4 class='mt-4'>Sharing the Personal Information</h4>
            <p>When you visit the website or downloading the application, we collect and store the name of the domain from which you access the internet, the date and time you access our site and the internet address of the website from which you link to our site, the search terms you enter into our search utility, browser software and internet service provider you use and any other relevant information, in order to improve security, analyse trends and administer the site. </p>

            <h4 class='mt-4'>Security</h4>
            <p>We are concerned about safeguarding the confidentiality of your Information. We take all precautions to protect the Personal Information both online and offline. We provide physical, electronic, and procedural safeguards to protect Information we process and maintain. We protect the information using technical and administrative security measures to reduce the risks of loss, misuse, unauthorized access, disclosure and alteration. If you believe your account has been abused, please contact us</p>
           <br> <p>We do not sell or rent your personal information to third parties for their marketing purposes without your explicit consent and we only use your information as described in the Privacy Policy. We view protection of your privacy as a very important community principle. We understand clearly that you and Your Information is one of our most important assets. </p>
          <br>  <p>Under no circumstances do we rent, trade or share the institutional/personal information that we have collected with any other company for their marketing purposes without your consent. We reserve the right to communicate your personal information to any third party that makes a legally-compliant request for its disclosure.</p>


            <h4 class='mt-4'>The General Data Protection Regulation (GDPR)</h4>
            <p>If you are a resident of the European Economic Area (EEA), you have certain data protection rights. <b>InfixLMS APP</b> to take reasonable steps to allow you to correct, amend, delete, or limit the use of your Personal Data.</p>
           <br> <p>If you wish to be informed what Personal Data we hold about you and if you want it to be removed from our systems, please contact us.</p>
          <br>  <p>In certain circumstances, you have the following data protection rights:</p>
           <ul class='list-group'>

                <li class='list-group-item'><b>The right to access, update or to delete the information we have on you.</b>  Whenever made possible, you can access, update or request deletion of your Personal Data directly within your account settings section. If you are unable to perform these actions yourself, please contact us to assist you.</li>
                <li class='list-group-item'><b>The right of rectification.</b> You have the right to have your information rectified if that information is inaccurate or incomplete.</li>
                <li class='list-group-item'><b>The right to object. </b> You have the right to object to our processing of your Personal Data.</li>
                <li class='list-group-item'><b>The right of restriction.</b> You have the right to request that we restrict the processing of your personal information.</li>
                <li class='list-group-item'><b>The right to data portability.</b> You have the right to be provided with a copy of the information we have on you in a structured, machine-readable and commonly used format.</li>
                <li class='list-group-item'><b>The right to withdraw consent. </b> You also have the right to withdraw your consent at any time where Digital Marketer Labs, LLC relied on your consent to process your personal information.</li>
            </ul>
            <p>Please note that we may ask you to verify your identity before responding to such requests. You have the right to complain to a Data Protection Authority about our collection and use of your Personal Data. For more information, please contact your local data protection authority in the European Economic Area (EEA).</p>
            <h4 class='mt-4'>Consent</h4>
            <p>We believe that, every user of our Application/Services/Website must be in a position to provide an informed consent prior to providing any Information required for the use of them Application/Services/Website. </p>
          <br>  <p>By registering with us , you are expressly consenting to our collection, processing, storing, disclosing and handling of your information as set forth in this Policy now and as amended by us. Processing, your information in any way, including, but not limited to, collecting, storing, deleting, using, combining, sharing, transferring and disclosing information, all of which activities will take place in Bangladesh. If you reside outside Bangladesh your information will be transferred, processed and stored in accordance with the applicable data protection laws of Bangladesh.</p>

            <h4 class='mt-4'>Changes to This Statement</h4>
            <p>As the Company evolves, our privacy policy will need to evolve as well to cover new situations.  You are advised to review this Policy regularly for any changes, as continued use is deemed approval of all changes.</p>
         <br>   <p>We may at any time modify the Terms of our Website without any prior notification to you. Should you wish to terminate your account due to a modification to the Terms or the Privacy Policy, you may do so email us at <b> <a href='mailto:support@spondonit.com'>support@spondonit.com</a></b></p>
        </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>";


        return $html;
    }

    public function down()
    {

    }
}
