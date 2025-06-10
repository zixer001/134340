<?php

// ตรวจสอบว่าฟังก์ชันยังไม่ถูกประกาศ
if (!function_exists('escape_html')) {
    function escape_html($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

// ฟังก์ชันสำหรับตรวจสอบ username ซ้ำ
if (!function_exists('checkUsernameExists')) {
    function checkUsernameExists($username) {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $stmt = $con->prepare("SELECT id FROM users WHERE username = ?");
                if (!$stmt) {
                    error_log("MySQL prepare error: " . $con->error);
                    return false;
                }
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $exists = $result->num_rows > 0;
                $stmt->close();
                return $exists;
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                return $stmt->fetch() !== false;
            }
        } catch (Exception $e) {
            error_log("Check username error: " . $e->getMessage());
        }
        return false;
    }
}

// ฟังก์ชันสำหรับตรวจสอบ email ซ้ำ
if (!function_exists('checkEmailExists')) {
    function checkEmailExists($email) {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
                if (!$stmt) {
                    error_log("MySQL prepare error: " . $con->error);
                    return false;
                }
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $exists = $result->num_rows > 0;
                $stmt->close();
                return $exists;
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                return $stmt->fetch() !== false;
            }
        } catch (Exception $e) {
            error_log("Check email error: " . $e->getMessage());
        }
        return false;
    }
}

// ฟังก์ชันสำหรับตรวจสอบ phone ซ้ำ
if (!function_exists('checkPhoneExists')) {
    function checkPhoneExists($phone) {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $stmt = $con->prepare("SELECT id FROM users WHERE phone = ?");
                if (!$stmt) {
                    error_log("MySQL prepare error: " . $con->error);
                    return false;
                }
                $stmt->bind_param("s", $phone);
                $stmt->execute();
                $result = $stmt->get_result();
                $exists = $result->num_rows > 0;
                $stmt->close();
                return $exists;
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
                $stmt->execute([$phone]);
                return $stmt->fetch() !== false;
            }
        } catch (Exception $e) {
            error_log("Check phone error: " . $e->getMessage());
        }
        return false;
    }
}

// ฟังก์ชันสำหรับสร้างผู้ใช้ใหม่ (แก้ไขแล้ว)
if (!function_exists('createUser')) {
    function createUser($username, $password, $email, $phone, $first_name, $last_name, $bank_name, $bank_account) {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $created_at = date('Y-m-d H:i:s');
            
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $sql = "INSERT INTO users (username, password, email, phone, first_name, last_name, bank_name, bank_account, status, balance, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active', 0.00, ?)";
                
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    error_log("MySQL prepare error: " . $con->error);
                    return false;
                }
                
                $stmt->bind_param("sssssssss", 
                    $username, $hashed_password, $email, $phone, 
                    $first_name, $last_name, $bank_name, $bank_account, $created_at
                );
                
                $result = $stmt->execute();
                if (!$result) {
                    error_log("MySQL execute error: " . $stmt->error);
                    $stmt->close();
                    return false;
                }
                
                $stmt->close();
                return true;
                
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $sql = "INSERT INTO users (username, password, email, phone, first_name, last_name, bank_name, bank_account, status, balance, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active', 0.00, ?)";
                
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    $username, $hashed_password, $email, $phone, 
                    $first_name, $last_name, $bank_name, $bank_account, $created_at
                ]);
                
                return $result;
            } else {
                error_log("No database connection available");
                return false;
            }
            
        } catch (Exception $e) {
            error_log("Create user error: " . $e->getMessage());
            error_log("Database type - MySQL: " . ($use_mysql ? 'true' : 'false') . ", SQLite: " . ($use_sqlite ? 'true' : 'false'));
            return false;
        }
    }
}

// ฟังก์ชันสำหรับดึงข้อมูลผู้ใช้
if (!function_exists('getUserByUsername')) {
    function getUserByUsername($username) {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $stmt = $con->prepare("SELECT id, username, password, email, first_name, last_name, status, balance, failed_attempts, locked_until, last_login FROM users WHERE username = ? OR email = ?");
                if (!$stmt) {
                    error_log("MySQL prepare error: " . $con->error);
                    return false;
                }
                $stmt->bind_param("ss", $username, $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                $stmt->close();
                return $user;
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $stmt = $pdo->prepare("SELECT id, username, password, email, first_name, last_name, status, balance, failed_attempts, locked_until, last_login FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$username, $username]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            error_log("Get user error: " . $e->getMessage());
        }
        return false;
    }
}

// ฟังก์ชันสำหรับอัปเดตการเข้าสู่ระบบล้มเหลว
if (!function_exists('updateFailedLogin')) {
    function updateFailedLogin($user_id, $failed_attempts) {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            $locked_until = null;
            if ($failed_attempts >= 5) {
                $locked_until = date('Y-m-d H:i:s', time() + (15 * 60));
            }
            
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $stmt = $con->prepare("UPDATE users SET failed_attempts = ?, locked_until = ? WHERE id = ?");
                if (!$stmt) {
                    return false;
                }
                $stmt->bind_param("isi", $failed_attempts, $locked_until, $user_id);
                $result = $stmt->execute();
                $stmt->close();
                return $result;
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $stmt = $pdo->prepare("UPDATE users SET failed_attempts = ?, locked_until = ? WHERE id = ?");
                return $stmt->execute([$failed_attempts, $locked_until, $user_id]);
            }
        } catch (Exception $e) {
            error_log("Update failed login error: " . $e->getMessage());
        }
        return false;
    }
}

// ฟังก์ชันสำหรับรีเซ็ตการเข้าสู่ระบบล้มเหลว
if (!function_exists('resetFailedLogin')) {
    function resetFailedLogin($user_id) {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            $now = date('Y-m-d H:i:s');
            
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $stmt = $con->prepare("UPDATE users SET failed_attempts = 0, locked_until = NULL, last_login = ? WHERE id = ?");
                if (!$stmt) {
                    return false;
                }
                $stmt->bind_param("si", $now, $user_id);
                $result = $stmt->execute();
                $stmt->close();
                return $result;
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $stmt = $pdo->prepare("UPDATE users SET failed_attempts = 0, locked_until = NULL, last_login = ? WHERE id = ?");
                return $stmt->execute([$now, $user_id]);
            }
        } catch (Exception $e) {
            error_log("Reset failed login error: " . $e->getMessage());
        }
        return false;
    }
}

// ฟังก์ชันสำหรับบันทึก log การเข้าสู่ระบบ
if (!function_exists('logLogin')) {
    function logLogin($user_id, $ip_address, $user_agent, $status, $notes = null) {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            $login_time = date('Y-m-d H:i:s');
            
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $stmt = $con->prepare("INSERT INTO login_logs (user_id, ip_address, user_agent, login_time, status, notes) VALUES (?, ?, ?, ?, ?, ?)");
                if (!$stmt) {
                    return false;
                }
                $stmt->bind_param("isssss", $user_id, $ip_address, $user_agent, $login_time, $status, $notes);
                $result = $stmt->execute();
                $stmt->close();
                return $result;
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $stmt = $pdo->prepare("INSERT INTO login_logs (user_id, ip_address, user_agent, login_time, status, notes) VALUES (?, ?, ?, ?, ?, ?)");
                return $stmt->execute([$user_id, $ip_address, $user_agent, $login_time, $status, $notes]);
            }
        } catch (Exception $e) {
            error_log("Log login error: " . $e->getMessage());
        }
        return false;
    }
}

// ฟังก์ชันสำหรับดึงการตั้งค่าเว็บไซต์
if (!function_exists('getSiteSettings')) {
    function getSiteSettings() {
        global $con, $pdo, $use_mysql, $use_sqlite;
        
        try {
            if ($use_mysql && isset($con) && $con instanceof mysqli) {
                $stmt = $con->prepare("SELECT * FROM settings ORDER BY id DESC LIMIT 1");
                if (!$stmt) {
                    return false;
                }
                $stmt->execute();
                $result = $stmt->get_result();
                $settings = $result->fetch_assoc();
                $stmt->close();
                return $settings;
            } elseif ($use_sqlite && isset($pdo) && $pdo instanceof PDO) {
                $stmt = $pdo->prepare("SELECT * FROM settings ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            error_log("Get settings error: " . $e->getMessage());
        }
        return false;
    }
}

// ฟังก์ชันสำหรับดีบักสถานะฐานข้อมูล
if (!function_exists('debugDatabaseStatus')) {
    function debugDatabaseStatus() {
        global $con, $pdo, $use_mysql, $use_sqlite, $db_error;
        
        $status = [
            'mysql_available' => $use_mysql,
            'sqlite_available' => $use_sqlite,
            'mysql_connection' => isset($con) && $con instanceof mysqli,
            'sqlite_connection' => isset($pdo) && $pdo instanceof PDO,
            'error' => $db_error
        ];
        
        error_log("Database status: " . json_encode($status));
        return $status;
    }
}

?>