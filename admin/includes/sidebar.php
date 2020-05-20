<nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <!-- sidebar-brand  -->
                <div class="sidebar-item sidebar-brand">
                    <a href="portada.php">Prickles</a>
                </div>
                <!-- sidebar-header  -->
                <div class="sidebar-item sidebar-header d-flex flex-nowrap">
                    <div class="user-pic">
                    <?php  
                      $db = mysqli_connect("den1.mysql6.gear.host","herbario","Informatica1*","herbario"); 
                      if($_SESSION['img'] = 'NULL'  && !isset($_SESSION['nombre'])){
                        echo '<img src="img/user.jpg"/>'; 
                      } else {
                        $user = $_SESSION['nombre'];
                        $sql = "SELECT * FROM usuarios WHERE nombre = '$user'";
                        $sth = $db->query($sql);
                        $result=mysqli_fetch_array($sth);
                        echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['img'] ).'" alt="thumbnail"/>';      
                      }
                    ?>
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?php 
                          if (!isset($_SESSION['nombre'])) { 
                              echo 'Invitado';
                              } else {
                                echo $_SESSION['nombre'];
                                } 
                                ?>
                        </span>
                        <span class="user-role"><?php
                          if (!isset($_SESSION['tipoUsuario'])) { 
                              echo 'Invitado';
                              } else {
                                echo $_SESSION['tipoUsuario'];
                                } 
                                ?></span>
                    </div>
                </div>
                <!-- sidebar-menu  -->
                <br/>
                <div class="sidebar-item sidebar-menu">
                    <ul>
                        <br/>
                        <li class="header-menu">
                            <span>General</span>
                        </li>
                        <br/>
                        <li><?php
                          if (!isset($_SESSION['tipoUsuario'])) { 
                                echo '<a href="plantas.php">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-text">Mi Perfil</span>
                                </a>';
                    
                              } else {
                                echo '<a href="perfil.php">
                                        <i class="fa fa-home"></i>
                                        <span class="menu-text">Mi Perfil</span>
                                    </a>';
                                } 
                                ?>

                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                            <i class="fa fa-tree"></i>
                                <span class="menu-text">Plantas</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="plantas.php">Ver plantas
                                        <span class="badge badge-pill badge-danger">Todos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <?php
                                        if (!isset($_SESSION['tipoUsuario'])) { 
                                                echo '<a href="plantas.php">Añadir plantas
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                    
                                            } else {
                                                echo '<a href="addPlantas.php">Añadir plantas
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                                } 
                                        ?>
                                    </li>
                                    <li>
                                        
                                        <?php
                                        if (!isset($_SESSION['tipoUsuario'])) { 
                                                echo '<a href="plantas.php">Actualizar plantas
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                    
                                            } else {
                                                echo '<a href="updatePlantas.php">Actualizar plantas
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                                } 
                                        ?>
                                    </li>
                                    <li> 
                                        <?php
                                        if (!isset($_SESSION['tipoUsuario'])) { 
                                                echo '<a href="plantas.php">Eliminar plantas
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                    
                                            } else {
                                                echo '<a href="deletePlantas.php">Eliminar plantas
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                                } 
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-file"></i>
                                <span class="menu-text">Noticias</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                <li>
                                        <a href="noticias.php">Ver noticias
                                        <span class="badge badge-pill badge-danger">Todos</span>
                                        </a>
                                    </li>
                                    <li>                                    
                                        <?php
                                        if (!isset($_SESSION['tipoUsuario'])) { 
                                                echo '<a href="noticias.php">Añadir noticias
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                    
                                            } else {
                                                echo '<a href="addNoticias.php">Añadir noticias
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                                } 
                                        ?>
                                        
                                    </li>
                                    <li>
                                        <?php
                                        if (!isset($_SESSION['tipoUsuario'])) { 
                                                echo '<a href="noticias.php">Actualizar noticias
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                    
                                            } else {
                                                echo '<a href="updateNoticias.php">Actualizar noticias
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                                } 
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if (!isset($_SESSION['tipoUsuario'])) { 
                                                echo '<a href="noticias.php">Eliminar noticias
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                    
                                            } else {
                                                echo '<a href="deleteNoticias.php">Eliminar noticias
                                                <span class="badge badge-pill badge-success">Autores</span>
                                                </a>';
                                                } 
                                        ?>
                                    </li>    
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-footer  -->
            <div class="sidebar-footer">
                
                <div>
                    <a href="logout.php">
                        <i class="fa fa-power-off"></i>
                    </a>
                </div>

            </div>
        </nav>