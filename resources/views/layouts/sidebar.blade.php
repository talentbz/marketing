<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="bx bx-home-circle"></i><span class="badge rounded-pill bg-info float-end">04</span>
                        <span key="t-dashboards">@lang('translation.Dashboards')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="index" key="t-default">@lang('translation.Default')</a></li>
                        <li><a href="javascript:void(0);" key="t-saas">@lang('translation.Saas')</a></li>
                        <li><a href="javascript:void(0);" key="t-crypto">@lang('translation.Crypto')</a></li>
                        <li><a href="javascript:void(0);" key="t-blog">@lang('translation.Blog')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">@lang('translation.Layouts')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow"
                                key="t-vertical">@lang('translation.Vertical')</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="layouts-light-sidebar"
                                        key="t-light-sidebar">@lang('translation.Light_Sidebar')</a></li>
                                <li><a href="layouts-compact-sidebar"
                                        key="t-compact-sidebar">@lang('translation.Compact_Sidebar')</a></li>
                                <li><a href="layouts-icon-sidebar"
                                        key="t-icon-sidebar">@lang('translation.Icon_Sidebar')</a></li>
                                <li><a href="layouts-boxed" key="t-boxed-width">@lang('translation.Boxed_Width')</a>
                                </li>
                                <li><a href="layouts-preloader" key="t-preloader">@lang('translation.Preloader')</a>
                                </li>
                                <li><a href="layouts-colored-sidebar"
                                        key="t-colored-sidebar">@lang('translation.Colored_Sidebar')</a></li>
                                <li><a href="layouts-scrollable" key="t-scrollable">@lang('translation.Scrollable')</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow"
                                key="t-horizontal">@lang('translation.Horizontal')</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="layouts-horizontal" key="t-horizontal">@lang('translation.Horizontal')</a>
                                </li>
                                <li><a href="layouts-hori-topbar-light"
                                        key="t-topbar-light">@lang('translation.Topbar_Light')</a></li>
                                <li><a href="layouts-hori-boxed-width"
                                        key="t-boxed-width">@lang('translation.Boxed_Width')</a></li>
                                <li><a href="layouts-hori-preloader"
                                        key="t-preloader">@lang('translation.Preloader')</a></li>
                                <li><a href="layouts-hori-colored-header"
                                        key="t-colored-topbar">@lang('translation.Colored_Header')</a></li>
                                <li><a href="layouts-hori-scrollable"
                                        key="t-scrollable">@lang('translation.Scrollable')</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="menu-title" key="t-apps">@lang('translation.Apps')</li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-calendar">@lang('translation.Calendar')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span key="t-chat">@lang('translation.Chat')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="bx bx-file"></i>
                        <span class="badge rounded-pill bg-success float-end"
                            key="t-new">@lang('translation.New')</span>
                        <span key="t-file-manager">@lang('translation.File_Manager')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-store"></i>
                        <span key="t-ecommerce">@lang('translation.Ecommerce')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-products">@lang('translation.Products')</a></li>
                        <li><a href="javascript: void(0);" key="t-product-detail">@lang('translation.Product_Detail')</a></li>
                        <li><a href="javascript: void(0);" key="t-orders">@lang('translation.Orders')</a></li>
                        <li><a href="javascript: void(0);" key="t-customers">@lang('translation.Customers')</a></li>
                        <li><a href="javascript: void(0);" key="t-cart">@lang('translation.Cart')</a></li>
                        <li><a href="javascript: void(0);" key="t-checkout">@lang('translation.Checkout')</a></li>
                        <li><a href="javascript: void(0);" key="t-shops">@lang('translation.Shops')</a></li>
                        <li><a href="javascript: void(0);" key="t-add-product">@lang('translation.Add_Product')</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-bitcoin"></i>
                        <span key="t-crypto">@lang('translation.Crypto')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-wallet">@lang('translation.Wallet')</a></li>
                        <li><a href="javascript: void(0);" key="t-buy">@lang('translation.Buy_Sell')</a></li>
                        <li><a href="javascript: void(0);" key="t-exchange">@lang('translation.Exchange')</a></li>
                        <li><a href="javascript: void(0);" key="t-lending">@lang('translation.Lending')</a></li>
                        <li><a href="javascript: void(0);" key="t-orders">@lang('translation.Orders')</a></li>
                        <li><a href="javascript: void(0);" key="t-kyc">@lang('translation.KYC_Application')</a></li>
                        <li><a href="javascript: void(0);" key="t-ico">@lang('translation.ICO_Landing')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-envelope"></i>
                        <span key="t-email">@lang('translation.Email')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-inbox">@lang('translation.Inbox')</a></li>
                        <li><a href="javascript: void(0);" key="t-read-email">@lang('translation.Read_Email')</a></li>
                        <li>
                            <a href="javascript: void(0);">
                                <span class="badge rounded-pill badge-soft-success float-end" key="t-new">@lang('translation.New')</span>
                                <span key="t-email-templates">@lang('translation.Templates')</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);" key="t-basic-action">@lang('translation.Basic_Action')</a></li>
                                <li><a href="javascript: void(0);" key="t-alert-email">@lang('translation.Alert_Email')</a></li>
                                <li><a href="javascript: void(0);" key="t-bill-email">@lang('translation.Billing_Email')</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-receipt"></i>
                        <span key="t-invoices">@lang('translation.Invoices')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-invoice-list">@lang('translation.Invoice_List')</a></li>
                        <li><a href="javascript: void(0);" key="t-invoice-detail">@lang('translation.Invoice_Detail')</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase-alt-2"></i>
                        <span key="t-projects">@lang('translation.Projects')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-p-grid">@lang('translation.Projects_Grid')</a></li>
                        <li><a href="javascript: void(0);" key="t-p-list">@lang('translation.Projects_List')</a></li>
                        <li><a href="javascript: void(0);" key="t-p-overview">@lang('translation.Project_Overview')</a></li>
                        <li><a href="javascript: void(0);" key="t-create-new">@lang('translation.Create_New')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-task"></i>
                        <span key="t-tasks">@lang('translation.Tasks')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-task-list">@lang('translation.Task_List')</a></li>
                        <li><a href="javascript: void(0);" key="t-kanban-board">@lang('translation.Kanban_Board')</a></li>
                        <li><a href="javascript: void(0);" key="t-create-task">@lang('translation.Create_Task')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">@lang('translation.Contacts')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-user-grid">@lang('translation.User_Grid')</a></li>
                        <li><a href="javascript: void(0);" key="t-user-list">@lang('translation.User_List')</a></li>
                        <li><a href="javascript: void(0);" key="t-profile">@lang('translation.Profile')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <span class="badge rounded-pill bg-success float-end"
                            key="t-new">@lang('translation.New')</span>
                        <i class="bx bx-detail"></i>
                        <span key="t-blog">@lang('translation.Blog')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-blog-list">@lang('translation.Blog_List')</a></li>
                        <li><a href="javascript: void(0);" key="t-blog-grid">@lang('translation.Blog_Grid')</a></li>
                        <li><a href="javascript: void(0);" key="t-blog-details">@lang('translation.Blog_Details')</a></li>
                    </ul>
                </li>

                <li class="menu-title" key="t-pages">@lang('translation.Pages')</li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <span class="badge rounded-pill bg-success float-end"
                            key="t-new">@lang('translation.New')</span>
                        <i class="bx bx-user-circle"></i>
                        <span key="t-authentication">@lang('translation.Authentication')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-login">@lang('translation.Login')</a></li>
                        <li><a href="javascript: void(0);" key="t-login-2">@lang('translation.Login') 2</a></li>
                        <li><a href="javascript: void(0);" key="t-register">@lang('translation.Register')</a></li>
                        <li><a href="javascript: void(0);" key="t-register-2">@lang('translation.Register') 2</a></li>
                        <li><a href="javascript: void(0);" key="t-recover-password">@lang('translation.Recover_Password')</a></li>
                        <li><a href="javascript: void(0);" key="t-recover-password-2">@lang('translation.Recover_Password') 2</a></li>
                        <li><a href="javascript: void(0);" key="t-lock-screen">@lang('translation.Lock_Screen')</a></li>
                        <li><a href="javascript: void(0);" key="t-lock-screen-2">@lang('translation.Lock_Screen') 2</a></li>
                        <li><a href="javascript: void(0);" key="t-confirm-mail">@lang('translation.Confirm_Mail')</a></li>
                        <li><a href="javascript: void(0);" key="t-confirm-mail-2">@lang('translation.Confirm_Mail') 2</a></li>
                        <li><a href="javascript: void(0);" key="t-email-verification">@lang('translation.Email_verification')</a></li>
                        <li><a href="javascript: void(0);" key="t-email-verification-2">@lang('translation.Email_verification') 2</a></li>
                        <li><a href="javascript: void(0);" key="t-two-step-verification">@lang('translation.Two_step_verification')</a></li>
                        <li><a href="javascript: void(0);" key="t-two-step-verification-2">@lang('translation.Two_step_verification') 2</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-file"></i>
                        <span key="t-utility">@lang('translation.Utility')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-starter-page">@lang('translation.Starter_Page')</a></li>
                        <li><a href="javascript: void(0);" key="t-maintenance">@lang('translation.Maintenance')</a></li>
                        <li><a href="javascript: void(0);" key="t-coming-soon">@lang('translation.Coming_Soon')</a></li>
                        <li><a href="javascript: void(0);" key="t-timeline">@lang('translation.Timeline')</a></li>
                        <li><a href="javascript: void(0);" key="t-faqs">@lang('translation.FAQs')</a></li>
                        <li><a href="javascript: void(0);" key="t-pricing">@lang('translation.Pricing')</a></li>
                        <li><a href="javascript: void(0);" key="t-error-404">@lang('translation.Error_404')</a></li>
                        <li><a href="javascript: void(0);" key="t-error-500">@lang('translation.Error_500')</a></li>
                    </ul>
                </li>

                <li class="menu-title" key="t-components">@lang('translation.Components')</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-tone"></i>
                        <span key="t-ui-elements">@lang('translation.UI_Elements')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-alerts">@lang('translation.Alerts')</a></li>
                        <li><a href="javascript: void(0);" key="t-buttons">@lang('translation.Buttons')</a></li>
                        <li><a href="javascript: void(0);" key="t-cards">@lang('translation.Cards')</a></li>
                        <li><a href="javascript: void(0);" key="t-carousel">@lang('translation.Carousel')</a></li>
                        <li><a href="javascript: void(0);" key="t-dropdowns">@lang('translation.Dropdowns')</a></li>
                        <li><a href="javascript: void(0);" key="t-grid">@lang('translation.Grid')</a></li>
                        <li><a href="javascript: void(0);" key="t-images">@lang('translation.Images')</a></li>
                        <li><a href="javascript: void(0);" key="t-lightbox">@lang('translation.Lightbox')</a></li>
                        <li><a href="javascript: void(0);" key="t-modals">@lang('translation.Modals')</a></li>
                        <li><a href="javascript: void(0);" key="t-offcanvas">@lang('translation.Offcanvas')</a></li>
                        <li><a href="javascript: void(0);" key="t-range-slider">@lang('translation.Range_Slider')</a></li>
                        <li><a href="javascript: void(0);" key="t-session-timeout">@lang('translation.Session_Timeout')</a></li>
                        <li><a href="javascript: void(0);" key="t-progress-bars">@lang('translation.Progress_Bars')</a></li>
                        <li><a href="javascript: void(0);" key="t-sweet-alert">@lang('translation.Sweet_Alert')</a></li>
                        <li><a href="javascript: void(0);" key="t-tabs-accordions">@lang('translation.Tabs_&_Accordions')</a></li>
                        <li><a href="javascript: void(0);" key="t-typography">@lang('translation.Typography')</a></li>
                        <li><a href="javascript: void(0);" key="t-video">@lang('translation.Video')</a></li>
                        <li><a href="javascript: void(0);" key="t-general">@lang('translation.General')</a></li>
                        <li><a href="javascript: void(0);" key="t-colors">@lang('translation.Colors')</a></li>
                        <li><a href="javascript: void(0);" key="t-rating">@lang('translation.Rating')</a></li>
                        <li><a href="javascript: void(0);" key="t-notifications">@lang('translation.Notifications')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="bx bxs-eraser"></i>
                        <span class="badge rounded-pill bg-danger float-end">10</span>
                        <span key="t-forms">@lang('translation.Forms')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-form-elements">@lang('translation.Form_Elements')</a></li>
                        <li><a href="javascript: void(0);" key="t-form-layouts">@lang('translation.Form_Layouts')</a></li>
                        <li><a href="javascript: void(0);" key="t-form-validation">@lang('translation.Form_Validation')</a>
                        </li>
                        <li><a href="javascript: void(0);" key="t-form-advanced">@lang('translation.Form_Advanced')</a></li>
                        <li><a href="javascript: void(0);" key="t-form-editors">@lang('translation.Form_Editors')</a></li>
                        <li><a href="javascript: void(0);" key="t-form-upload">@lang('translation.Form_File_Upload')</a></li>
                        <li><a href="javascript: void(0);" key="t-form-xeditable">@lang('translation.Form_Xeditable')</a></li>
                        <li><a href="javascript: void(0);" key="t-form-repeater">@lang('translation.Form_Repeater')</a></li>
                        <li><a href="javascript: void(0);" key="t-form-wizard">@lang('translation.Form_Wizard')</a></li>
                        <li><a href="javascript: void(0);" key="t-form-mask">@lang('translation.Form_Mask')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-list-ul"></i>
                        <span key="t-tables">@lang('translation.Tables')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-basic-tables">@lang('translation.Basic_Tables')</a></li>
                        <li><a href="javascript: void(0);" key="t-data-tables">@lang('translation.Data_Tables')</a></li>
                        <li><a href="javascript: void(0);" key="t-responsive-table">@lang('translation.Responsive_Table')</a></li>
                        <li><a href="javascript: void(0);" key="t-editable-table">@lang('translation.Editable_Table')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-bar-chart-alt-2"></i>
                        <span key="t-charts">@lang('translation.Charts')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-apex-charts">@lang('translation.Apex_Charts')</a></li>
                        <li><a href="javascript: void(0);" key="t-e-charts">@lang('translation.E_Charts')</a></li>
                        <li><a href="javascript: void(0);" key="t-chartjs-charts">@lang('translation.Chartjs_Charts')</a></li>
                        <li><a href="javascript: void(0);" key="t-flot-charts">@lang('translation.Flot_Charts')</a></li>
                        <li><a href="javascript: void(0);" key="t-ui-charts">@lang('translation.Toast_UI_Charts')</a></li>
                        <li><a href="javascript: void(0);" key="t-knob-charts">@lang('translation.Jquery_Knob_Charts')</a></li>
                        <li><a href="javascript: void(0);" key="t-sparkline-charts">@lang('translation.Sparkline_Charts')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-aperture"></i>
                        <span key="t-icons">@lang('translation.Icons')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-boxicons">@lang('translation.Boxicons')</a></li>
                        <li><a href="javascript: void(0);"
                                key="t-material-design">@lang('translation.Material_Design')</a></li>
                        <li><a href="javascript: void(0);" key="t-dripicons">@lang('translation.Dripicons')</a></li>
                        <li><a href="javascript: void(0);" key="t-font-awesome">@lang('translation.Font_awesome')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-map"></i>
                        <span key="t-maps">@lang('translation.Maps')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);" key="t-g-maps">@lang('translation.Google_Maps')</a></li>
                        <li><a href="javascript: void(0);" key="t-v-maps">@lang('translation.Vector_Maps')</a></li>
                        <li><a href="javascript: void(0);" key="t-l-maps">@lang('translation.Leaflet_Maps')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-share-alt"></i>
                        <span key="t-multi-level">@lang('translation.Multi_Level')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);" key="t-level-1-1">@lang('translation.Level_1.1')</a></li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow"
                                key="t-level-1-2">@lang('translation.Level_1.2')</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);" key="t-level-2-1">@lang('translation.Level_2.1')</a>
                                </li>
                                <li><a href="javascript: void(0);" key="t-level-2-2">@lang('translation.Level_2.2')</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
