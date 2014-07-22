<aside>	
    <!-- aside item: Mini profile -->
    <div class="my-profile">
        <a href="javascript:void(0)" class="my-profile-pic">
            <img src="/theme/img/avatar/avatar_0.jpg" alt="" />
        </a>
        <span class="first-child">
            Welcome 
            <br />
            <strong>
                <?php
                $sessionEmployoeeInfo = new \Zend\Session\Container('employee_info');
                echo $sessionEmployoeeInfo->name . '!';
                ?>
            </strong>
        </span>
        <!--<span><a href="<?php //echo $this->url('admin/employee/profile')       ?>">Edit Profile </a></span>-->
    </div>
    <div class="divider"></div>
    <!-- end aside item: Mini profile -->

    <!-- aside item: Menu -->
    <div class="sidebar-nav-fixed">

        <ul class="menu" id="accordion-menu-js">
            <li >
                <a href="javascript:void(0)"><i class="icon-off"></i>Dashboard <span class="badge">2</span></a>
                <ul>
                    <li>
                        <a href="<?php echo $this->url('admin/dashboard') ?>" class="expanded">Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->url('admin/logout') ?>" >Logout</a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="javascript:void(0)"><i class="icon-user"></i>Admin<span class="badge">2</span></a>
                <ul>
                    <li>
                        <a href="<?php echo $this->url('admin/employee') ?>" >Employee Management</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->url('admin/departments') ?>" >Department Management</a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
    <div class="divider"></div>
</aside>