<div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Subheading</small>
                        </h1>
                        <?php 
                            // if ($database->connection) {
                            //     echo "True";
                            // }

                        // To test from database.php
                            // $sql= "SELECT * FROM users WHERE id=1";
                            // $result= $database->query($sql);
                            // $user_found= mysqli_fetch_array($result);
                        
                            // echo $user_found['username'];

                            // Coming from user.php from line 3
                            // $users= new User();
                            // $result_set= $users->find_all_users();
                            // while($row= mysqli_fetch_array($result_set)){
                            //     echo $row['last_name']."</br>";
                            // }

                            
                            // Without using instantiation
                            // $result_set= User::find_all_users();
                            // while($row= mysqli_fetch_array($result_set)){
                            //     echo $row['last_name']."</br>";
                            // }
                       
                            
                            // $found_user= User::find_user_by_id(2);
                            // $user= User::instantiation($found_user);
                            // echo $user->username;


                            // $users= User::find_all_users();
                            // foreach ($users as $user) {
                            //     echo $user->username."</br>";
                            // }

                            // $found_user= User::find_user_by_id(2);
                            // echo $found_user->username;
                            //$pictures= new Pictures();


                            //echo $found_user['last_name'];



                            //Inserting Data into the database using user.php from the create() method


                            // $user= new User();
                            // $user->username= "Jim-Sheg";
                            // $user->password= "Ogunwale";
                            // $user->first_name= "Jimmy";
                            // $user->last_name= "Wale";

                            // $user->create();

                            // Updating the data in the database from users.php on line 134
                            // $user= User::find_user_by_id(7);
                            // $user->username= "ennyone";
                            // $user->password= "Enny2000";
                            // $user->first_name= "Adeyemi";
                            // $user->last_name= "Wasiu";
                            // $user->update();

                            // $user= User::find_user_by_id(5);
                            // $user->delete();
                            
                            $users= User::find_by_id(10);
                            echo $users->username;
                          
                                // $photo = Photo:: find_by_id(10);
                                // echo $photo->filename;

                            // Using save method for abstraction

                            // $user= User::find_user_by_id(6);
                            // $user->first_name="My FirstName";
                            // $user-> save();

                            //This method create another users
                            // $user= new User();
                            // $user->username="Oyedele";
                            // $user->password= "Babatunde";
                            // $user->first_name= "Mubarak";
                            // $user->last_name= "Mutbasy";
                            // $user->save();
                            
                            /*******Using the Photo Class extended Testing**********/
                            // $photos= Photo::find_all_users();
                            // foreach ($photos as $photo) {
                            //     echo $photo->title;
                            // }


                            //Photo Class
                            // $photo= new Photo();
                            // $photo->title= "Student";
                            // $photo->size=  20;
                            // $photo->create();

                            //echo INCLUDES_PATH;
                        ?>  
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
