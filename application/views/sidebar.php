            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    
                    <li class="logo">
                        <a href="<?php echo site_url('user'); ?>"><img src="<?php echo site_url('/assets/images/slogo.png');?>" alt="Bluescan" title="Bluescan logo"/></a>
                    </li>
                    
                    
                    <li class="xn-profile">
                        <!--<a class="profile-mini" href="#">
                            <img alt="John Doe" src="assets/images/users/avatar.jpg">
                        </a> -->
                        <div class="profile">
                        <!--    <div class="profile-image">
                                <img alt="John Doe" src="assets/images/users/avatar.jpg">
                            </div> -->
                            <div class="profile-data">
                                <div class="profile-data-name">Hello! <?php echo $user_name; ?></div>
                                <div class="profile-data-title"><?php echo $user_role; ?></div>
                            </div>
                         <!--   <div class="profile-controls">
                                <a class="profile-control-left" href="pages-profile.html"><span class="fa fa-info"></span></a>
                                <a class="profile-control-right" href="pages-messages.html"><span class="fa fa-envelope"></span></a>
                            </div> -->
                        </div>                                                                        
                    </li>
                    <?php //echo 'asdasdasdasdasd'; //print_r($tasks);die; ?>
                    
                    <?php if($this->user->role_code == 'sadmin' && $this->session->userdata('session_company_id') == ''){ ?>
                        <?php if(in_array('company_list', $tasks)||in_array('add_company', $tasks)||in_array('question_list', $tasks) || in_array('question_group_list', $tasks)|| in_array('company_office_list', $tasks) || in_array('edit_company', $tasks) || in_array('update_company_status', $tasks)){ ?> 
                        <li <?php if($this->uri->segment(1) == 'company'){ ?> class="active" <?php } ?> >
                            <a href="<?php echo site_url('company'); ?>" title="Company"><span class="fa fa-suitcase"></span> <span class="xn-text">Company</span></a>                        
                        </li> 
                        <?php } ?>
                   <?php }else { ?>
                        
                     
                    
                    
                    
                    <?php if(in_array('dashboard', $tasks)){ ?>
                    <li <?php if($this->uri->segment(2) == 'dashboard'){ ?> class="active" <?php } ?> >
                        <a href="<?php echo site_url('user/dashboard'); ?>" title="Dashboard" ><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
                    </li> 

                    <?php } ?>
                    
                    
                    
                    <?php if(in_array('company_list', $tasks)||in_array('add_company', $tasks)||in_array('question_list', $tasks) || in_array('question_group_list', $tasks)|| in_array('company_office_list', $tasks) || in_array('edit_company', $tasks) || in_array('update_company_status', $tasks) || in_array('region_list', $tasks)||in_array('add_region', $tasks)|| in_array('edit_region', $tasks)||in_array('update_region_status', $tasks)||in_array('branch_list', $tasks)||in_array('add_branch', $tasks) || in_array('edit_branch', $tasks) || in_array('update_branch_status', $tasks)||in_array('guard_list', $tasks) || in_array('add_guard', $tasks)|| in_array('edit_guard', $tasks) || in_array('update_site_status', $tasks)||in_array('site_guard_assignment', $tasks)){ ?> 
                    <li  class="xn-openable <?php if($mainTab == 'company'){ ?>  active<?php } ?>" >
                        <a href="<?php echo site_url('company'); ?>" title="Company"><span class="fa fa-suitcase"></span> <span class="xn-text">Company</span></a>                        
                        <ul>
                            <?php if(in_array('company_list', $tasks)||in_array('add_company', $tasks)||in_array('question_list', $tasks) || in_array('question_group_list', $tasks)|| in_array('company_office_list', $tasks) || in_array('edit_company', $tasks) || in_array('update_company_status', $tasks) ){ ?> 
                            <li  <?php if($this->uri->segment(1) == 'company'){ ?> class="active" <?php } ?> >
                                <a href="<?php echo site_url('company'); ?>" title="Company"><span class="fa fa-suitcase"></span>Company</a>                        
                            </li>
                            <?php } ?>
                            <?php if(in_array('region_list', $tasks)||in_array('add_region', $tasks)|| in_array('edit_region', $tasks)||in_array('update_region_status', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(1) == 'region'){ ?> class="active" <?php } ?>>
                                <a href="<?php echo site_url('region'); ?>" title="My Regions"><span class="fa fa-location-arrow"></span>My Regions</a>
                            </li>
                            <?php } ?>
                             <?php if(in_array('branch_list', $tasks)||in_array('add_branch', $tasks) || in_array('edit_branch', $tasks) || in_array('update_branch_status', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(1) == 'branch'){ ?> class="active" <?php } ?>>
                                <a href="<?php echo site_url('branch'); ?>" title="My Branches"><span class="fa fa-sitemap"></span>My Branches</a>
                            </li>
                            <?php } ?>
                            <!--
                            <?php if(in_array('guard_list', $tasks) || in_array('add_guard', $tasks)|| in_array('edit_guard', $tasks) || in_array('update_site_status', $tasks)||in_array('site_guard_assignment', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(1) == 'guard'){ ?> class="active" <?php } ?>>
                                <a href="<?php echo site_url('guard'); ?>" title="Guard"><span class="fa fa-tags"></span> <span class="xn-text">Guard</span></a>
                            </li>
                            <?php } ?>
                            -->
                        
                            
                            
                        </ul>
                    
                    </li> 
                    <?php } ?>
                    
                    <?php if(in_array('customer_list', $tasks)||in_array('add_customer', $tasks)||in_array('edit_customer', $tasks) || in_array('update_customer_status', $tasks)||in_array('add_site', $tasks)||in_array('site_list', $tasks) || in_array('edit_site', $tasks) || in_array('update_site_status', $tasks)||in_array('site_guard_assignment', $tasks)){ ?> 
                    <li class="xn-openable <?php if($mainTab == 'customer'){ ?> active<?php } ?>" >
                        <a href="<?php echo site_url('customer'); ?>" title="Customer"><span class="fa fa-users"></span><span class="xn-text">Customer</span></a>                        
                        <ul>
                             <?php if(in_array('customer_list', $tasks)||in_array('add_customer', $tasks)||in_array('edit_customer', $tasks) || in_array('update_customer_status', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(1) == 'customer'){ ?> class="active" <?php } ?> >
                                <a href="<?php echo site_url('customer'); ?>" title="My Customers"><span class="fa fa-users"></span>My Customers</a>                        
                            </li>
                             <?php } ?>
                            
                            <?php if(in_array('add_site', $tasks)||in_array('site_list', $tasks) || in_array('edit_site', $tasks) || in_array('update_site_status', $tasks)||in_array('site_guard_assignment', $tasks)){ ?>
                                        <li <?php if($this->uri->segment(1) == 'site'){ ?> class="active" <?php } ?>>
                                            <a href="<?php echo site_url('site/siteList'); ?>" title="Customer Sites"><span class="fa fa-map-marker"></span>Customer Sites</a>
                                        </li>                
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                    
                    
                    
                    
                    
                  
                   
                    

                    
                    
                    
                    <?php if(in_array('user_list', $tasks)||in_array('add_user', $tasks) || in_array('edit_user', $tasks) || in_array('update_user_status', $tasks)){ ?> 
                    <li <?php if($this->uri->segment(1) == 'user' && $this->uri->segment(2) != 'dashboard'){ ?> class="active" <?php } ?> >
                        <a href="<?php echo site_url('user/users'); ?>" title="Employees"><span class="fa fa-user"></span> <span class="xn-text">Employees</span></a>
                    </li>
                    <?php } ?>
                   
                    
                    
                    
                    
                   
                    
                    
                    
              
                  
                   <?php if(in_array('convaynce_report', $tasks)||in_array('drill_down_report', $tasks) || in_array('guard_inspection_report', $tasks)){ ?> 

                    <li <?php if($this->uri->segment(1) == 'report'){ ?> class="xn-openable active" <?php }else{ ?> class="xn-openable" <?php } ?>>
                        <a href="<?php echo site_url('report'); ?>" title="Reports"><span class="fa fa-file-o"></span><span class="xn-text">Reports</span></a>
                        <ul>
                            <?php if(in_array('convaynce_report', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(1) == 'report' && $this->uri->segment(2) == '' ){ ?> class="active" <?php } ?>><a href="<?php echo site_url('report'); ?>" title="Conveyance List"><span class="fa fa-file-o"></span>Conveyance List</a></li>
                             <?php } ?>
                            <?php if(in_array('drill_down_report', $tasks) ){ ?> 
                            <li <?php if($this->uri->segment(2) == 'drillDownReport'){ ?> class="active" <?php } ?>><a href="<?php echo site_url('report/drillDownReport'); ?>" title="Conveyance Drill Down"><span class="fa fa-file-o"></span>Conveyance Drill Down</a></li>
                            <?php } ?>
                             <?php if(in_array('guard_inspection_report', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(2) == 'guardIspectionReport'){ ?> class="active" <?php } ?>><a href="<?php echo site_url('report/guardIspectionReport'); ?>" title="Guard Inspection(s)"><span class="fa fa-file-o"></span>Guard Inspection(s)</a></li>
                             <?php } ?>
                            <?php if(in_array('rejected_inspection_report', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'rejectedInspectionReport' ){ ?> class="active" <?php } ?>><a href="<?php echo site_url('report/rejectedInspectionReport'); ?>" title="Rejected Inspection(s)"><span class="fa fa-file-o"></span>Rejected Inspection(s)</a></li>
                             <?php } ?>
                        </ul>                        
                    </li>                   
                     
                    <?php } ?>
                    
                    
                    <?php if(in_array('guard_attendance', $tasks)||in_array('late_attendance', $tasks)){ ?> 
                     <li class="xn-openable <?php if($mainTab == 'Attendance'){ ?> active<?php } ?>" >
                         <a  href="<?php echo site_url('guard/guardAttendance/'); ?>" title="Attendance" ><span class="fa fa-file-text-o"></span><span class="xn-text">Attendance</span></a>
                        <ul>
                            <?php if(in_array('guard_attendance', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(2) == 'guardAttendance'){ ?> class="active" <?php } ?> >
                                <a  href="<?php echo site_url('guard/guardAttendance/'); ?>" title="Guard Attendance" ><span class="fa fa-file-text-o"></span>Guard Attendance</a>
                            </li>                
                            <?php } ?>
                             <?php if(in_array('late_attendance', $tasks)){ ?> 
                            <li <?php if($this->uri->segment(2) == 'lateAttendance'){ ?> class="active" <?php } ?> >
                                <a  href="<?php echo site_url('guard/lateAttendance/'); ?>" title="Late Attendance" ><span class="fa fa-warning"></span>Late Attendance</a>
                            </li>                
                            <?php } ?>
                        </ul>    
                     </li>
                    <?php } ?>
                    
                    
                    
                    <?php } ?>
                     <li <?php if($this->uri->segment(2) == 'changePassword'){ ?> class="active" <?php } ?>>
                        <a href="<?php echo site_url('user/changePassword'); ?>" title="Change Password"><span class="fa fa-gear"></span> <span class="xn-text">Change Password</span></a>
                    </li>
                    
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR --> 