<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/11/2016
 * Time: 1:57 PM
 */
class DB
{
    private $host, $db_username, $db_password, $db_name, $conn;


    // __constructor
    public function __construct($host, $db_name, $db_username, $db_password)
    {
        if (is_string($host) && is_string($db_name) && is_string($db_username) && is_string($db_password))
        {
            if (!empty($host) && !empty($db_username) && !empty($db_name))
            {
                $this->host = $host;
                $this->db_username = $db_username;
                $this->db_password = $db_password;
                $this->db_name = $db_name;

                $this->conn = $this->initiate_db_connection($this->host, $this->db_name, $this->db_username, $this->db_password);
            }
            else
            {
                echo("<h5>Please provide host, db_name, db_username as not empty strings!</h5><p/>");
                echo("<a href='index.php'>back</a>");
                exit;
            }
        }
        else
        {
            echo("<h5>Please provide host, db_name, db_username and db_password as strings!</h5><p/>");
            echo("<a href='index.php'>back</a>");
            exit;

        }

    }
    // end __constructor


    /**
     * @param $host
     * @param $db_name
     * @param $db_username
     * @param $db_password
     * @return mysqli
     */
    private function initiate_db_connection($host, $db_name, $db_username, $db_password)
    {
        if (is_string($host) && is_string($db_name) && is_string($db_username) && is_string($db_password))
        {
            if (!empty($host) && !empty($db_username) && !empty($db_name))
            {
                $conn = @mysqli_connect($host, $db_username, $db_password, $db_name);

                if(!$conn)
                {
                    echo(mysqli_connect_error());
                    echo("<a href='index.php'>back</a>");
                    exit;
                }

                return $conn;
            }
            else
            {
                echo("<h5>Please provide host, db_name, db_username as not empty strings!</h5><p/>");
                echo("<a href='index.php'>back</a>");
                exit;
            }
        }
        else
        {
            echo("<h5>Please provide host, db_name, db_username and db_password as strings!</h5><p/>");
            echo("<a href='index.php'>back</a>");
            exit;
        }
    }
    // end initiate_db_connection()

    /**
     * @param $table_name
     * @param $fields
     * @param $values
     * @return bool|mysqli_result
     */
    public function insert($table_name, $fields, $values)
    {
        $values_arr = array();

        $fields_str = null;
        $values_str = null;

        if (count($fields) !== count($values))
        {
            echo("<h5>Please provide a matching number of fields and its values!</h5><p/>");
            echo("<a href='index.php'>back</a>");
            exit;
        }
        else
        {

            foreach($values as $value)
            {
                $value = "'".(string)$value."'";
                array_push($values_arr,$value);
            }

            $fields_str = implode(",", $fields);
            $values_str = implode(",", $values_arr);
        }

        if($fields_str != null && $values_str != null)
        {
            $table_name = mysqli_real_escape_string($this->conn,$table_name);

            $insert_query = "INSERT INTO $table_name ($fields_str) VALUES ($values_str)";

            $insert = mysqli_query($this->conn, $insert_query);

            if (!$insert)
            {
//                echo("<h5>Error inserting new account!</h5><p/>".mysqli_error($this->conn)."<p/>");
//                echo("<a href='index.php'>back</a>");
//                exit;
                $insert = $insert;
            }
            else
            {
//                return $insert; // this should be returning true
                $insert = $insert;
            }

            return array('insert_status'=>$insert, 'error'=>mysqli_error($this->conn));
        }
        else
        {
            echo("<h5>Invalid Insert Query!</h5><p/>");
            echo("<a href='index.php'>back</a>");
            exit;
        }

    }
    // end insert()

    /**
     * @param $table_name
     * @param $user_name
     * @return array
     */
    public function select_user ($table_name, $user_name)
    {
        $user_name = "'".$user_name."'";
        $table_name = mysqli_real_escape_string($this->conn, $table_name);
        $select_query = "SELECT user_name FROM $table_name WHERE user_name = $user_name";

        $select = mysqli_query($this->conn, $select_query);

        if(!$select)
        {
            $select_status = $select;
            $result = mysqli_error($this->conn);
        }
        else
        {
            $select_status = true;
            $result = mysqli_fetch_assoc($select);
        }

        return array('select_status'=>$select_status, 'select_result'=>$result);
    }
    // end select_user()

    /**
     * @param $table_name
     * @param $user_name
     * @param $password
     * @return array
     */
    public function user_signin ($table_name, $user_name, $password)
    {
        $user_name = "'".$user_name."'";
        $password = "'".$password."'";
        $table_name = mysqli_real_escape_string($this->conn, $table_name);

        $select_query = "SELECT user_name FROM $table_name WHERE user_name = $user_name AND password = $password";

        $signin = mysqli_query($this->conn, $select_query);

        if($signin->num_rows <= 0)
        {
            $signin_status = false;
            $result = "User info not found!";
        }
        else
        {
            $signin_status = true;
            $result = mysqli_fetch_assoc($signin);
        }

        return array('signin_status'=>$signin_status, 'signin_result'=>$result);
    }
    // end user_signin()

}
?>