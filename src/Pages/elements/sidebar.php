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
            <a class="nav-link collapsed" href="registerUser.php">
                <i class="bi bi-person-plus-fill"></i>
                <span>Cadastrar usuários</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="adminSchoolClass.php">
                <i class="fa-solid fa-chalkboard-user class-i"></i>  
                <span>Turmas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="adminMatters.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                </svg>
                <span>Cadastrar Matérias</span>
            </a>
        </li>

    </ul>

</aside>


<?php } else {
        if ($_SESSION['teacher'] === 1) { ?>
            <aside id="sidebar" class="sidebar">

                <ul class="sidebar-nav" id="sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="pages-blank.html">                                            
                            <i class="fa-solid fa-user-tie"></i>
                            <span>Professor</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="schoolClassModule.php">                            
                            <i class="fa-solid fa-chalkboard-user class-i"></i>                        
                            <span>Turmas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="pages-blank.html">
                            <i class="fa-solid fa-book"></i>
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