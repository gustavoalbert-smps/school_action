<?php 
require_once '../../vendor/autoload.php';

if ($_SESSION['admin'] === 1) { ?>

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="adminPanel.php">
                <i class="bi bi-grid"></i>
                <span>Painel do Administrador</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Professor</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Aluno</span>
            </a>
        </li>

    </ul>

</aside>


<?php } else { 
        if ($_SESSION['teacher'] === 1) { ?>
            <aside id="sidebar" class="sidebar">

                <ul class="sidebar-nav" id="sidebar-nav">

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="homePage.php">
                            <i class="bi bi-file-earmark"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="pages-blank.html">
                            <i class="bi bi-file-earmark"></i>
                            <span>Professor</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="pages-blank.html">
                            <i class="bi bi-file-earmark"></i>
                            <span>Matérias</span>
                        </a>
                    </li>

                </ul>

            </aside>
            
<?php   } else { ?>
            <aside id="sidebar" class="sidebar">

                <ul class="sidebar-nav" id="sidebar-nav">

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="homePage.php">
                            <i class="bi bi-file-earmark"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="pages-blank.html">
                            <i class="bi bi-file-earmark"></i>
                            <span>Aluno</span>
                        </a>
                    </li>

                </ul>

            </aside>
<?php 
    }
} 
?>