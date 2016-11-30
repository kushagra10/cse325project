<?php
$username="root";
        $password="";
        $host="localhost";
        $db="wp";
        
        $conn = mysqli_connect($host, $username, $password, $db);
        /* if (!$conn) {
            die("Could not connect to database" . mysqli_error($conn));
        }
        else {
            echo "Connected successfully";
        } */
        mysqli_select_db($conn, $db);
        $sql = "SELECT * FROM ft_main_search_input where search_id = (SELECT Max(search_id) "
                . "from ft_main_search_input)";
        $search_string = mysqli_query($conn, $sql);
        
        $row = mysqli_fetch_array($search_string);
        
        $cname = $row['course'];
        $csource = $row['source'];
        $a_year = $row['audit_year'];
        
        $sql = "select rank,
                                schoolName,
                                universityName,
								universityType,
								programName,
								programLength,
                                acceptanceRate,
                                intake,
								maleFemalePercent,
                                avgTestScore,
                                tutionFeesInState,
                                tutionFeesOutState
                from
                                report rp
                                join school sc
                                                on rp.schoolId = sc.schoolId
                                                and rp.year = $a_year
                                join program pg
                                                on rp.programId = pg.programId
												and pg.programName like ('%$cname%')
                                join university un
                                				on un.universityId = sc.universityId
                                join source sr
                                                on rp.sourceId = sr.sourceId
                                                and sourceName like ('%$csource%')";
											
        
        $result = mysqli_query($conn, $sql);
        
        echo '<table border="1">'
                    
                .'<tr>'
                                                                .'<th>Rank</th>'
                                                                .'<th>School Name</th>'
                                                                .'<th>University Name</th>'
																.'<th>Program</th>'
																.'<th>Program Length</th>'
                                                                .'<th>Acceptance Rate</th>'
                                                                .'<th>Intake</th>'
																.'<th>Male to Female Ratio</th>'
                                                                .'<th>Average Test Score</th>'
                                                                .'<th>Tuition (In-state)</th>'
                                                                .'<th>Tuition (Out-state)</th>'
                                                                
                .'</tr>';
        while($row = mysqli_fetch_array($result)) {
            $rank = $row['rank'];
            $school = $row['schoolName'];
            $univ = $row['universityName'];
            $prog = $row['programName'];
			$progLen = $row['programLength'];
            $arate = $row['acceptanceRate'];
            $intake = $row['intake'];
			$intakeRatio = $row['maleFemalePercent'];
            $avgtest = $row['avgTestScore'];
            $tin = $row['tutionFeesInState'];
            $tout = $row['tutionFeesOutState'];
            
            
            echo '<tr>';
            echo '<td>'.$rank.'</td>';
            echo '<td>'.$school.'</td>';
            echo '<td>'.$univ.'</td>';
            echo '<td>'.$prog.'</td>';
			echo '<td>'.$progLen.'</td>';
            echo '<td>'.$arate.'</td>';
            echo '<td>'.$intake.'</td>';
			echo '<td>'.$intakeRatio.'</td>';
            echo '<td>'.$avgtest.'</td>';
            echo '<td>'.$tin.'</td>';
            echo '<td>'.$tout.'</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        
        $conn_close = mysqli_close($conn);
        /* if (! $conn_close) {
            die("Could not close database connection");
        }
        else {
            echo "Connection to database closed successfully";
        } */
	?>