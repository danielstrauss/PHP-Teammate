<div class="w3-lime w3-card w3-container">
<a href="index.php" class="w3-bar-item w3-large w3-button"><i class="fa fa-home"></i></a>

     <div class="w3-right"> 
        
    

        <?php
        if(!isset($_COOKIE["username"]))
        {
        echo '<a href="register.php" class="w3-bar-item w3-large w3-button"><i class="fas fa-plus"></i></a>';
        }
        if(isset($_COOKIE["username"]) && ($_COOKIE["role"])=="admin")
        {
        echo '<a href="admin.php" class="w3-bar-item w3-large w3-button"><i class="fas fa-user-cog"></i></a>';
        echo '<a href="shoppinglist.php" class="w3-bar-item w3-large w3-button"><i class="fas fa-shopping-cart"></i></a>';

        }
        if(isset($_COOKIE['username']))
        {
            echo '<a href="teammate.php" class="w3-bar-item w3-large w3-button"><i class="fas fa-futbol"></i></a>';
            echo '<a href="user_cp.php" class="w3-bar-item w3-large w3-button"><i class="fas fa-user"></i></i></a>';
            echo '<a href="logout.php" class="w3-bar-item w3-large w3-button"><i class="fas fa-sign-out-alt"></i></a>';
        }
        ?>
			
	</div>
</div>
    
    

<table>
        <tr>
            <td>
                <div class="w3-margin-left w3-tiny w3-border-bottom w3-border-light-grey">
                    <?php if(isset($_COOKIE['username']))
                    {?>
                    <i class="fas fa-info"></i>
                    </div> 
                </td>
            <td>
            <div class="w3-tiny w3-text-grey w3-border-bottom w3-border-light-grey">
                    Du bist eingeloggt als <?php echo '' . $_COOKIE['username'] . ' mit der ID: ' . $_COOKIE['user_id'] . ''; ?>
                    <?php } ?>
                </div>
            </td>
        </tr>
    </table>

