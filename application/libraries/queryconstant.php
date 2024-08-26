<?php
class Queryconstant
{
   public $queryGetUserByUsernamePassword = "SELECT u.user_id,u.email,u.status,IFNULL(u.company_id,c.company_id) as company_id,uc.is_published as company_status,
                                                    concat(u.first_name,' ',u.last_name) as name,
                                                    IFNULL(uc.company_logo_url,c.company_logo_url) as company_logo_url,
                                                    ur.role_id,r.role_name,r.code,r.role_order, 
                                                   (Select  group_concat(region_id) as region_id FROM user_role WHERE user_id = ur.user_id group by user_id) as region_ids,
                                                   (Select  group_concat(branch_id) as branch_id FROM user_role WHERE user_id = ur.user_id group by user_id) as branch_ids,
                                                   (Select  group_concat(site_id) as site_id FROM user_role WHERE user_id = ur.user_id group by user_id) as site_ids,
                                                    group_concat(tr.task_id) AS user_tasks_ids,
                                                    group_concat(t.task_name) AS user_tasks
                                             FROM user u
                                             INNER JOIN user_role ur ON ur.user_id = u.user_id
                                             INNER JOIN role r ON r.role_id = ur.role_id
                                             LEFT JOIN role_task tr ON tr.role_id = r.role_id
                                             LEFT JOIN task t ON t.task_id = tr.task_id
                                             LEFT JOIN site s ON ur.site_id = s.site_id
                                             LEFT JOIN branch b ON s.branch_id = b.branch_id
                                             LEFT JOIN region re ON b.region_id = re.region_id
                                             LEFT JOIN company c ON re.company_id = c.company_id
                                             LEFT JOIN company uc ON u.company_id = uc.company_id
                                             WHERE u.user_name = ?
                                             AND u.password = ? 
                                             GROUP BY u.user_id";
   
   public $queryGetComapnyIdForCompanySession   = "SELECT u.company_id
                                                 FROM user u
                                                 WHERE u.user_id = ?";
   
    public $queryGetComapnyIdForRegionCompanySession   = "SELECT re.company_id
                                               FROM user u
                                               INNER JOIN user_role ur ON ur.user_id = u.user_id
                                               LEFT JOIN region re ON re.region_id = ur.region_id
                                               WHERE u.user_id = ?
                                               GROUP BY u.user_id";
    
    
   
   
    public $queryGetAllCompanyList = "SELECT c.*, cl.license_code FROM company c LEFT JOIN company_license cl ON cl.company_license_id = c.license_code_id LIMIT ?, ?";
   
    public $queryGetAllCompanyListForRegionSession   = "SELECT c.* 
                                               FROM user u
                                               LEFT JOIN user_role ur ON ur.user_id = u.user_id
                                               LEFT JOIN region re ON ur.region_id = re.region_id
                                               LEFT JOIN company c ON c.company_id = re.company_id
                                               WHERE u.user_id = ?
                                               GROUP BY u.user_id";
   
    public $queryGetAllCompanyListForBranchSession   = "SELECT c.* 
                                               FROM user u
                                               LEFT JOIN user_role ur ON ur.user_id = u.user_id
                                               LEFT JOIN branch b ON b.region_id = ur.region_id
                                               LEFT JOIN region re ON b.region_id = re.region_id
                                               LEFT JOIN company c ON c.company_id = re.company_id
                                               WHERE u.user_id = ?
                                               GROUP BY u.user_id";
    
    public  $queryGetAllRegionBranchSiteDataByCompanyIds = "SELECT group_concat(DISTINCT r.region_id) as region_ids,
                                                            group_concat(DISTINCT b.branch_id) as branch_ids, 
                                                            group_concat(DISTINCT s.site_id) as site_ids
                                               FROM region r
                                               LEFT JOIN branch b ON r.region_id = b.region_id
                                               LEFT JOIN site s ON s.branch_id = b.branch_id
                                               #WHERE# ";
    
    public $queryGetAllBranchesSiteByRegionIds  = "SELECT group_concat(DISTINCT b.branch_id) as branch_ids, group_concat(DISTINCT s.site_id) as site_ids
                                               FROM branch b
                                               LEFT JOIN region r ON r.region_id = b.region_id
                                               LEFT JOIN site s ON s.branch_id = b.branch_id
                                               #WHERE# ";
   
    public $queryGetAllSiteByBranchIds  = "SELECT group_concat(DISTINCT s.site_id) as site_ids
                                               FROM site s
                                               LEFT JOIN branch b ON b.branch_id = s.branch_id
                                               #WHERE# ";
    
    
   public $queryGetCompanyDetailsByCompId    = "SELECT c.*, cl.license_code, cl.valid_from, cl.valid_to FROM company c LEFT JOIN company_license cl ON cl.company_license_id = c.license_code_id  WHERE company_id = ?";
   
   public $queryGetAllCompanyLicenseList    = "SELECT *
                                                FROM company_license
                                                WHERE license_code NOT IN
                                                    (SELECT company_license_id
                                                     FROM company WHERE company_id <> ?)";

  
   public $queryGetAllCompanyOfficeList = "SELECT * FROM company_office
                                            WHERE company_id = ?
                                            LIMIT ?, ?";
    
   public $queryGetCompanyOfficeDetailsByOfficeId = "SELECT * FROM company_office WHERE company_office_id = ?";
   
   
   public $quertUpdateUserSessionByUserId = "UPDATE user set session_token=? , apns_token=? where user_id=?";

   public $queryGetUserByUserToken = "SELECT * from user where session_token=?";
   
   public $queryGetGuardDataByGuardId   = "SELECT g.*,u.user_id,u.email,u.status as user_status,
                                                    concat(u.first_name,' ',u.last_name) as name,
                                                    ur.role_id,r.role_name,r.code, 
                                                    group_concat(tr.task_id) AS user_tasks 
                                                    FROM guard g
                                            INNER JOIN user u ON u.guard_id = g.guard_id
                                            INNER JOIN user_role ur ON ur.user_id = u.user_id
                                            INNER JOIN role r ON r.role_id = ur.role_id
                                            LEFT JOIN role_task tr ON tr.role_id = r.role_id
                                            LEFT JOIN task t ON t.task_id = tr.task_id
                                            LEFT JOIN guard_document gdoc ON g.guard_id = gdoc.guard_id
                                            Where g.guard_id = ?";

   public $queryGetGuardDocByGuardId = "SELECT * from guard_document where guard_id = ? AND document_type_id = ?";
   
   public $queryGetEmployeeDocByEmployeeId = "SELECT ed.*, dt.document_type from employee_document ed
                                              LEFT JOIN document_type dt ON ed.document_type_id = dt.document_type_id
                                              WHERE ed.employee_id = ?";
   
   public $queryGetAllSiteDetailsBySiteIdQR = "SELECT s.*
                                                FROM site s  
                                                WHERE s.site_id = ? AND s.qr_code = ?";
   
   public $queryGetAllSiteDetailsBySiteId   = "SELECT s.* , r.region_id , concat(c.first_name,c.last_name) as customer_name, concat(com.company_name) AS company_name
                                                FROM site s  
                                                LEFT JOIN branch b ON b.branch_id = s.branch_id
                                                LEFT JOIN region r ON r.region_id = b.region_id
                                                LEFT JOIN customer c ON c.customer_id = s.customer_id
                                                 LEFT JOIN company com ON com.company_id = c.company_id
                                                WHERE s.site_id = ?";
   
   public $queryGetThresholdvaluesBySiteId = "SELECT t1.site_id,
                                                    TIME_TO_SEC(t1.time_diffrence),
                                                    t1.threshold_time
                                             FROM
                                               ( SELECT t.site_id,
                                                        ABS(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(concat(?,' ', shift_time), '%Y-%m-%d %H:%i:%s'), DATE_FORMAT(?, '%Y-%m-%d %H:%i:%s')))) AS time_diffrence,
                                                        threshold_time
                                                FROM
                                                  ( SELECT s.site_id,
                                                           s.first_shift_threshold_time AS threshold_time,
                                                           s.first_shift_start_time AS shift_time
                                                   FROM site s
                                                   UNION SELECT s.site_id,
                                                                s.second_shift_threshold_time AS threshold_time,
                                                                s.second_shift_start_time AS shift_time
                                                   FROM site s
                                                   UNION SELECT s.site_id,
                                                                s.third_shift_threshold_time AS threshold_time,
                                                                s.third_shift_start_time AS shift_time
                                                   FROM site s) AS t
                                                WHERE t.site_id =?) AS t1
                                             ORDER BY t1.time_diffrence ASC LIMIT 1";

    public $queryGetAllSiteDrop              = "SELECT * FROM site";
   
   public $queryGetAllSiteQuestionBySiteId  = "SELECT q.*,sq.* 
                                                FROM site s
                                                INNER JOIN site_question sq ON s.site_id = sq.site_id
                                                INNER JOIN question q ON sq.question_id = q.question_id
                                                WHERE s.site_id = ?";
   
   public $queryGetAllCustomerList  = "SELECT  concat(cust.first_name,' ',cust.last_name) as customer_name, cust.* ,c.company_name  
                                        FROM customer cust
                                        INNER JOIN company c ON cust.company_id = c.company_id
                                        ORDER BY cust.customer_id DESC
                                        LIMIT ?, ?";
   
   public $queryGetCustomerDetailsByCustomerId   = "SELECT  cust.*  FROM customer cust WHERE cust.customer_id = ? ";
                                                

  public $queryGetAllUserList = "SELECT u.*, r.role_name as role_name FROM user u
                                LEFT JOIN user_role ur ON u.user_id = ur.user_id
                                LEFT JOIN role r ON ur.role_id = r.role_id
  								              ##WHERE##
                                GROUP BY ur.user_id ##LIMIT## ";

  public $queryGetAllUserPageList = "SELECT u.*,e.company_employee_id,e.system_id ,r.role_name as role_name,r.role_order FROM user u
  LEFT JOIN user_role ur ON u.user_id = ur.user_id
  LEFT JOIN role r ON ur.role_id = r.role_id
  LEFT JOIN employee e ON e.user_id = u.user_id
  LIMIT ?, ?";
  
  /*public $queryGetAllUserRole = "SELECT * FROM role WHERE role_id NOT IN
                                                    (SELECT role_id
                                                     FROM user_role WHERE user_id <> ?)";*/
  
  public $queryGetUserDetailsByUserId  = "SELECT u.*,e.*, r.role_id , r.code as role_code ,c.company_name,u.status as user_status,c.company_logo_url,
                                            IFNULL(ur.company_id,u.company_id) as company_ids,
                                            group_concat(ur.region_id) as region_ids,
                                            group_concat(ur.branch_id) as branch_ids,
                                            group_concat(ur.site_id) as site_ids,
                                            (SELECT group_concat(l.language_name) FROM languages l INNER JOIN employee_language el ON el.language_id  = l.language_id  WHERE el.employee_id = e.employee_id GROUP BY el.employee_id) as language_known
                                            FROM user u
                                          LEFT JOIN user_role ur ON u.user_id = ur.user_id
                                          LEFT JOIN role r ON ur.role_id = r.role_id
                                          LEFT JOIN employee e ON u.user_id = e.user_id
                                          LEFT JOIN company c ON u.company_id = c.company_id
                                          WHERE u.user_id = ? group by ur.user_id";

  public $queryGetMultiUserRolls  = "SELECT * FROM user_role WHERE user_id = ?";

  public $queryGetAllUserRole = "SELECT * FROM role where role_order > ?";
  
  public $queryGetRoleByRoleCode    = "SELECT * FROM role where code = ?";

  public $queryGetAllSkill  = "SELECT * FROM skills";
  
  public $queryGetAllRegionListForCompany= "SELECT r.*, c.company_name, concat(u.first_name,' ',u.last_name) as user_name 
                                            FROM region r
                                            INNER JOIN company c ON r.company_id = c.company_id
                                            INNER JOIN user u ON r.user_id = u.user_id
                                            LIMIT ?, ?";
  
   public $queryGetAllRegionList= "SELECT  r.*, c.company_name, concat(u.first_name,' ',u.last_name) as user_name
                                   From user u
                                   LEFT JOIN user_role ur ON u.user_id = ur.user_id
                                   LEFT JOIN region r ON ur.region_id = r.region_id
                                   LEFT JOIN company c ON r.company_id = c.company_id
                                   LIMIT ?, ?";
   
   public $queryGetAllRegionLisForBranchSession = "SELECT  r.*, c.company_name, concat(u.first_name,' ',u.last_name) as user_name
                                   From user u
                                   INNER JOIN user_role ur ON u.user_id = ur.user_id
                                   INNER JOIN branch b ON ur.branch_id = b.branch_id
                                   INNER JOIN region r ON b.region_id = r.region_id
                                   INNER JOIN company c ON r.company_id = c.company_id
                                   LIMIT ?, ?";
  
     public $queryGetAllRegiondropdown   = "SELECT r.*, c.company_name FROM region r
                                INNER JOIN company c ON r.company_id = c.company_id
                                LIMIT ?, ?";
   
  public $queryGetAllRegionListByCustomer   = "SELECT r.*, c.company_name, concat(u.first_name,' ',u.last_name) as user_name FROM region r
                                INNER JOIN company c ON r.company_id = c.company_id
                                INNER JOIN customer cust ON cust.company_id = c.company_id
                                GRUOP BY c.company_id
                                LIMIT ?, ?";

  public $queryGetRegionDetailsByRegId = "SELECT * FROM region WHERE region_id = ?";
  
  public $queryGetAllQuestionList   = "SELECT * FROM question ques WHERE ques.company_id = ? LIMIT ?, ?";
  
  public $queryGetQuestionByCompanyId   = "SELECT *
                                            FROM question q
                                            WHERE q.company_id = ?
                                              AND q.question_id NOT IN
                                                (SELECT qg.question_id
                                                 FROM question_group qg
                                                 WHERE qg.group_id = ? )";
  
  public $queryGetQuestDetailsByQuesIdId  = "SELECT ques.* FROM question ques WHERE ques.question_id = ?";
  
  public $queryGetAllQuestionGroupList = "SELECT g.*  FROM `group` g WHERE g.company_id = ? LIMIT ?, ?"; 
  
  public $queryGetAllQuestionGroupDropdown  = "SELECT ques.* FROM question_group ques WHERE ques.company_id = ?";
  
  public $queryGetGroupDataByGroupId   = "SELECT g.* FROM `group` g WHERE g.group_id = ?";
  
  public $queryGetGroupQuestByGroupId = "SELECT g.*,q.question, qg.question_group_id
                                        FROM `group` g
                                        INNER JOIN question_group qg ON g.group_id = qg.group_id
                                        INNER JOIN question q ON qg.question_id = q.question_id
                                        WHERE g.group_id = ?";
  
  

 public $queryGetAllBranchList =    "SELECT b.*, r.region_name as reg_add , r.region_name
                                        From branch b
                                        INNER JOIN region r ON r.region_id = b.region_id
                                    LIMIT ?, ?";
 
  
  public $queryGetAllBranchListForBranchManager = "SELECT b.*, r.region_name as reg_add 
                                   From user u
                                   INNER JOIN user_role ur ON u.user_id = ur.user_id
                                   INNER JOIN branch b ON ur.branch_id = b.branch_id
                                   INNER JOIN region r ON b.region_id = r.region_id
                                   LIMIT ?, ?";
  
  public $queryGetAllBranchListForRegionManager = "SELECT b.*, r.region_name as reg_add 
                                   From user u
                                   INNER JOIN user_role ur ON u.user_id = ur.user_id
                                   INNER JOIN region r ON ur.region_id = r.region_id
                                   INNER JOIN branch b ON r.region_id = b.region_id
                                   LIMIT ?, ?";

  public $queryGetBranchDetailsByBId = "SELECT b.*, r.company_id as company_id FROM branch b
                                        LEFT JOIN region r ON b.region_id = r.region_id
                                        WHERE b.branch_id = ?";
  
  public $queryGetAllSiteListByCompanyId   = "SELECT s.*, b.branch_name, concat(c.first_name,' ',c.last_name) as customer_name, com.company_name as company_name FROM site s 
                                    INNER JOIN branch b ON s.branch_id = b.branch_id
                                    INNER JOIN customer c ON s.customer_id = c.customer_id
                                    INNER JOIN company com ON c.company_id = com.company_id
                                    #WHERE#
                                    ORDER BY s.site_id DESC LIMIT ?, ?";
  
 public $queryGetAllSiteListForRegionManager   = "SELECT s.*, b.branch_name, concat(c.first_name,' ',c.last_name) as customer_name, com.company_name as company_name  
                                                    From user u
                                                    INNER JOIN user_role ur ON u.user_id = ur.user_id
                                                    INNER JOIN region r ON ur.region_id = r.region_id
                                                    INNER JOIN branch b ON r.region_id = b.region_id
                                                    INNER JOIN site s ON b.branch_id = s.branch_id
                                                    INNER JOIN company com ON r.company_id = com.company_id
                                                    INNER JOIN customer c ON s.customer_id = c.customer_id
                                                     #WHERE#
                                                    ORDER BY s.site_id DESC LIMIT ?, ?";
  
 
  public $queryGetAllSiteListForBranchManager   = "SELECT s.*, b.branch_name, concat(c.first_name,' ',c.last_name) as customer_name, com.company_name as company_name  
                                                    From user u
                                                    INNER JOIN user_role ur ON u.user_id = ur.user_id
                                                    INNER JOIN branch b ON ur.branch_id = b.branch_id
                                                    INNER JOIN region r ON b.region_id = r.region_id
                                                    INNER JOIN site s ON b.branch_id = s.branch_id
                                                    INNER JOIN company com ON r.company_id = com.company_id
                                                    INNER JOIN customer c ON s.customer_id = c.customer_id
                                                     #WHERE#
                                                    ORDER BY s.site_id DESC LIMIT ?, ?";
  
  public $queryGetAllSiteList   = "SELECT s.*,concat(c.first_name,' ',c.last_name) as customer_name, com.company_name as company_name  
                                                    From site s
                                                    INNER JOIN customer c ON s.customer_id = c.customer_id
                                                    INNER JOIN company com ON c.company_id = com.company_id
                                                    #WHERE#
                                                    ORDER BY s.site_id DESC LIMIT ?, ?";
  
  public $queryGetAllSiteListForFo  = "SELECT s.*, b.branch_name, concat(c.first_name,' ',c.last_name) as customer_name, com.company_name as company_name  
                                                    From user u
                                                    INNER JOIN user_role ur ON u.user_id = ur.user_id
                                                    INNER JOIN site s ON ur.site_id = s.site_id
                                                    INNER JOIN branch b ON s.branch_id = b.branch_id
                                                    INNER JOIN region r ON b.region_id = r.region_id
                                                    INNER JOIN company com ON r.company_id = com.company_id
                                                    INNER JOIN customer c ON s.customer_id = c.customer_id
                                                     #WHERE#
                                                    ORDER BY s.site_id DESC LIMIT ?, ?";
 
  public $queryGetAllBranchDropdown = "SELECT b.* FROM branch b
                                    INNER JOIN region r ON b.region_id = r.region_id
                                    INNER JOIN company c ON r.company_id = c.company_id
                                    INNER JOIN customer cust ON c.company_id = cust.company_id
                                    #WHERE# GROUP BY b.branch_id ORDER BY b.branch_name ASC";
  
   public $queryGetAllCustomerDropdown  = "SELECT  cust.*  FROM customer cust #WHERE# ORDER BY cust.first_name ASC";
   
   public $queryGetAllGroupDropdownByCompanyId  = "SELECT g.* FROM `group` g WHERE g.company_id = ?";
   
   public $queryGetSiteGroupBySiteId    = "SELECT sg.* FROM `site_group` sg WHERE sg.site_id = ?";
   
   public $queryGetAllInspectionList    = "SELECT ins.*, concat(u.first_name,' ',u.last_name) as officer, concat(g.first_name,' ',g.last_name) as guard_name, s.address, s.city, s.zipcode FROM inspection_instance ins 
                                            LEFT JOIN user u ON ins.created_by = u.user_id 
                                            LEFT JOIN guard g ON ins.guard_id = g.guard_id 
                                            LEFT JOIN site s ON ins.site_id = s.site_id
                                            ORDER BY ins.created_by ASC LIMIT ?, ?";


  public $queryGetAllGuardList = "SELECT u.first_name,u.last_name,e.*, c.company_name FROM employee e
                                  INNER JOIN user u ON e.user_id = u.user_id 
                                  INNER JOIN user_role ur ON u.user_id = ur.user_id
                                  INNER JOIN role r ON ur.role_id = r.role_id AND r.code = 'GD'
                                  INNER JOIN company c ON u.company_id = c.company_id #WHERE#
                                  LIMIT ?, ?";

public $queryGetGuardDataByQrcode  = "SELECT e.*,
                                            e.employee_id AS guard_id,
                                            u.company_id,
                                            u.first_name,
                                            u.last_name,ea.designation,
                                            if(e.aadhar_card_verification = 1,concat(?,'/','verified-1.jpg'),concat(?,'/','verified-1-gray.jpg')) AS aadhar_card_verification_img_url,
                                            if(e.police_verification = 1,concat(?,'/','verified-2.jpg'),concat(?,'/','verified-2-gray.jpg')) AS police_verification_img_url,
                                            if(e.education_verification = 1,concat(?,'/','verified-6.jpg'),concat(?,'/','verified-6-gray.jpg')) AS education_verification_img_url,
                                            if(e.experience_verification = 1,concat(?,'/','verified-4.jpg'),concat(?,'/','verified-4-gray.jpg')) AS experience_verification_img_url,
                                            if(e.license_verification = 1,concat(?,'/','verified-5.jpg'),concat(?,'/','verified-5-gray.jpg')) AS license_verification_img_url,
                                            u.phone,
                                            u.mobile,
                                            u.p_address AS address,
                                            c.company_name,
                                            if(u.img_url!='',concat(?,'/',u.img_url),'') AS img_url,
                                            if(c.company_logo_url!='',concat(?,'/',c.company_logo_url),'') AS company_logo_url,
                                       (SELECT group_concat(l.language_name)
                                        FROM languages l
                                        INNER JOIN employee_language el ON el.language_id = l.language_id
                                        WHERE el.employee_id = e.employee_id
                                        GROUP BY el.employee_id) AS language_known,

                                       (SELECT site_id
                                        FROM employee_site
                                        WHERE employee_id = e.employee_id
                                        ORDER BY created_date DESC LIMIT 1) AS site_id
                                     FROM employee e
                                     INNER JOIN user u ON e.user_id = u.user_id
                                     LEFT JOIN employee_attendance ea ON ea.employee_id = e.employee_id
                                     INNER JOIN company c ON u.company_id = c.company_id
                                     WHERE u.qr_code = ?";

  /*public $queryGetGuardDataByQrcode  = "SELECT e.*,
                                            e.employee_id AS guard_id,
                                            u.company_id,
                                            u.first_name,
                                            u.last_name,r.role_name as designation,ur.site_id,
                                            if(e.aadhar_card_verification = 1,concat(?,'/','verified-1.jpg'),concat(?,'/','verified-1-gray.jpg')) AS aadhar_card_verification_img_url,
                                            if(e.police_verification = 1,concat(?,'/','verified-2.jpg'),concat(?,'/','verified-2-gray.jpg')) AS police_verification_img_url,
                                            if(e.education_verification = 1,concat(?,'/','verified-6.jpg'),concat(?,'/','verified-6-gray.jpg')) AS education_verification_img_url,
                                            if(e.experience_verification = 1,concat(?,'/','verified-4.jpg'),concat(?,'/','verified-4-gray.jpg')) AS experience_verification_img_url,
                                            if(e.license_verification = 1,concat(?,'/','verified-5.jpg'),concat(?,'/','verified-5-gray.jpg')) AS license_verification_img_url,
                                            u.phone,
                                            u.mobile,
                                            u.p_address AS address,
                                            c.company_name,
                                            if(u.img_url!='',concat(?,'/',u.img_url),'') AS img_url,
                                            if(c.company_logo_url!='',concat(?,'/',c.company_logo_url),'') AS company_logo_url,
                                       (SELECT group_concat(l.language_name)
                                        FROM languages l
                                        INNER JOIN employee_language el ON el.language_id = l.language_id
                                        WHERE el.employee_id = e.employee_id
                                        GROUP BY el.employee_id) AS language_known
                                      
                                     FROM employee e
                                     INNER JOIN user u ON e.user_id = u.user_id
                                     INNER JOIN user_role ur ON ur.user_id = u.user_id
                                     INNER JOIN role r ON r.role_id = ur.role_id
                                     INNER JOIN company c ON u.company_id = c.company_id

                                     WHERE u.qr_code = ?";  */


  public $queryGetSiteDataByQrcode  = "SELECT s.site_id,
                                        s.address,
                                        s.site_title as site_name,
                                        s.zipcode,
                                        s.city,
                                        s.contact_person,
                                        s.contact_number,
                                        s.contact_person,
                                        s.email_id,
                                        b.branch_id,
                                        b.branch_name,
                                        concat(c.first_name,' ',c.last_name) as customer_name,
                                        com.company_name,
                                        s.company_site_id,
                                        if(com.company_logo_url!='',concat(?,'/',com.company_logo_url),'') AS company_logo
                                     FROM site s
                                     INNER JOIN branch b ON s.branch_id = b.branch_id
                                     INNER JOIN customer c ON s.customer_id = c.customer_id
                                     INNER JOIN company com ON com.company_id = c.company_id
                                     WHERE s.qr_code = ?";
  
  public $queryGetSiteListByUserId = "SELECT
                                            s.qr_code,
                                            s.site_title,
                                            s.site_id,
                                            s.address,
                                            s.zipcode,
                                            s.city,
                                            s.contact_person,
                                            s.contact_number,
                                            s.contact_person,
                                            s.email_id,
                                            b.branch_id,
                                            b.branch_name,
                                            concat(c.first_name,' ',c.last_name) AS customer_name,
                                            com.company_name,
                                            s.company_site_id,
                                            if(com.company_logo_url!='',concat(?,'/',com.company_logo_url),'') AS company_logo,
                                            (SELECT group_concat(employee_id) as guard FROM `employee_site` Where site_id = s.site_id) as guard
                                     FROM user u 
                                     LEFT JOIN user_role ur ON ur.user_id = u.user_id
                                     LEFT JOIN site s ON s.site_id = ur.site_id
                                     LEFT JOIN branch b ON s.branch_id = b.branch_id
                                     LEFT JOIN customer c ON s.customer_id = c.customer_id
                                     LEFT JOIN company com ON com.company_id = c.company_id
                                     WHERE u.user_id = ? GROUP BY s.site_id";
  
  public $queryGetQuestionDataBySiteId  = "SELECT q.*
                                        FROM site_group sg
                                        INNER JOIN `group` g ON sg.group_id = g.group_id
                                        INNER JOIN question_group qg ON g.group_id = qg.group_id
                                        INNER JOIN question q ON qg.question_id = q.question_id
                                        WHERE sg.site_id = ? AND g.group_type = 1";
  
  public $queryCheckQuestionExistanceIngroup = "SELECT qg.*
                                        FROM question_group qg
                                        WHERE qg.group_id = ? AND qg.question_id = ? ";
  
  public $queryGetQuestionDataByGuardId = "SELECT q.*
                                        FROM  `group` g 
                                        INNER JOIN question_group qg ON g.group_id = qg.group_id
                                        INNER JOIN question q ON qg.question_id = q.question_id
                                        WHERE g.group_type = 2 AND g.group_id = 7 ";


  public $queryGetGuardDataBySiteId     = "SELECT e.employee_id as guard_id, u.company_id,
                                    u.first_name,if(u.img_url!='',concat(?,'/',u.img_url),'') as img_url,e.language_known,
                                    u.last_name, u.phone,u.mobile , u.p_address as address, u.l_address as address1,e.blood_group,e.company_employee_id,ea.designation,
                                    u.zip , 
                                   (SELECT group_concat(q.qualification_name) FROM qualification q INNER JOIN employee_qualification eq ON q.qualification_id = eq.qualification_id AND q.is_qualification = 0 WHERE eq.employee_id = e.employee_id GROUP BY eq.employee_id) as education_qualification,
                                   (SELECT group_concat(q.qualification_name) FROM qualification q INNER JOIN employee_qualification eq ON q.qualification_id = eq.qualification_id AND q.is_qualification = 1 WHERE eq.employee_id = e.employee_id GROUP BY eq.employee_id) as technical_qualification, 
                                    (SELECT group_concat(l.language_name) FROM languages l INNER JOIN employee_language el ON el.language_id  = l.language_id  WHERE el.employee_id = e.employee_id GROUP BY el.employee_id) as language_known 
                                    ,e.status
                                    ,e.is_deleted,u.created_by,
                                    IF(u.created_date = '0000-00-00 00:00:00',NULL,u.created_date) as created_date , u.qr_code
                                    FROM employee_site es
                                  INNER JOIN employee e ON es.employee_id = e.employee_id
                                  LEFT JOIN employee_attendance ea ON ea.employee_id = e.employee_id
                                  INNER JOIN user u ON u.user_id = e.user_id
                                  WHERE es.site_id = ?";

/*public $queryGetGuardDataBySiteId  = "SELECT e.employee_id as guard_id, u.company_id,
                                    u.first_name,if(u.img_url!='',concat(?,'/',u.img_url),'') as img_url,e.language_known,
                                    u.last_name, u.phone,u.mobile , u.p_address as address, u.l_address as address1,e.blood_group,e.company_employee_id,
                                    u.zip ,r.role_name as designation,
                                    (SELECT group_concat(q.qualification_name) FROM qualification q INNER JOIN employee_qualification eq ON q.qualification_id = eq.qualification_id AND q.is_qualification = 0 WHERE eq.employee_id = e.employee_id GROUP BY eq.employee_id) as education_qualification,
                                    (SELECT group_concat(q.qualification_name) FROM qualification q INNER JOIN employee_qualification eq ON q.qualification_id = eq.qualification_id AND q.is_qualification = 1 WHERE eq.employee_id = e.employee_id GROUP BY eq.employee_id) as technical_qualification, 
                                    (SELECT group_concat(l.language_name) FROM languages l INNER JOIN employee_language el ON el.language_id  = l.language_id  WHERE el.employee_id = e.employee_id GROUP BY el.employee_id) as language_known 
                                    ,e.status
                                    ,e.is_deleted,u.created_by,
                                    IF(u.created_date = '0000-00-00 00:00:00',NULL,u.created_date) as created_date , u.qr_code
                                    FROM user_role ur
                                    INNER JOIN user u ON u.user_id = ur.user_id
                                    INNER JOIN role r ON r.role_id = ur.role_id
                                    INNER JOIN employee e ON e.user_id = u.user_id
                                    LEFT JOIN employee_attendance ea ON ea.employee_id = e.employee_id
                                    WHERE ur.site_id = ?";   */                               

  public $queryGetAllGuardSiteList = "SELECT es.*, concat(u.first_name,' ',u.last_name) as guard_name FROM employee_site es
                                  INNER JOIN employee e ON es.employee_id = e.employee_id
                                  INNER JOIN user u ON u.user_id = e.user_id
                                  WHERE es.site_id = ? LIMIT ?, ?";

  public $queryGetGuardSiteDataByGuardSiteId = "SELECT  es.*, concat(u.first_name,' ',u.last_name) as guard_name FROM employee_site es
                                  INNER JOIN employee e ON es.employee_id = e.employee_id
                                  INNER JOIN user u ON u.user_id = e.user_id
                                  WHERE es.employee_site_id = ?";
  

  public $queryGetGuardAttendListByGId = "SELECT s.site_title,concat(u.first_name,' ',u.last_name) as guard_name,concat(ru.first_name,' ',ru.last_name) as recorded_name, ea.time_in,
                                            ea.site_arrival_time,ea.attendance_date, ea.employee_attendance_id, ea.employee_id, ea.remark  
                                           , concat(vu.first_name,' ',vu.last_name) as verified_by_name , ea.verified_by,ea.photo_url
                                            FROM employee_attendance ea
                                          INNER JOIN employee e ON ea.employee_id = e.employee_id
                                          INNER JOIN user u ON u.user_id = e.user_id
                                          LEFT JOIN user ru ON ru.user_id = ea.recorded_by
                                          LEFT JOIN user vu ON vu.user_id = ea.verified_by
                                          INNER JOIN site s ON s.site_id   = ea.site_id
                                          WHERE TIME_TO_SEC(ea.site_arrival_time) < TIME_TO_SEC(ea.time_in) 
                                          #WHERE#
                                          ORDER BY ea.attendance_date DESC LIMIT ?, ?";
  
  public $queryGetGuardAttendanceList   = "SELECT s.site_title,concat(u.first_name,' ',u.last_name) as guard_name,concat(ru.first_name,' ',ru.last_name) as recorded_name, ea.time_in,
                                            ea.site_arrival_time,ea.attendance_date, ea.employee_attendance_id, ea.employee_id, ea.remark  
                                           , concat(vu.first_name,' ',vu.last_name) as verified_by_name , ea.verified_by,ea.photo_url ,
                                           if((TIME_TO_SEC(ea.site_arrival_time) < TIME_TO_SEC(ea.time_in)),1,0) as attendance_type
                                            FROM employee_attendance ea
                                          INNER JOIN employee e ON ea.employee_id = e.employee_id
                                          INNER JOIN user u ON u.user_id = e.user_id
                                          LEFT JOIN user ru ON ru.user_id = ea.recorded_by
                                          LEFT JOIN user vu ON vu.user_id = ea.verified_by
                                          INNER JOIN site s ON s.site_id   = ea.site_id
                                          #WHERE# GROUP BY ea.attendance_date
                                          ORDER BY ea.attendance_date DESC";

  public $queryGetInspectionDataById    = "SELECT ins.*, concat(u.first_name,' ',u.last_name) as officer, concat(g.first_name,' ',g.last_name) as guard_name, s.address, s.city, s.zipcode FROM inspection_instance ins 
                                            LEFT JOIN user u ON ins.created_by = u.user_id 
                                            LEFT JOIN guard g ON ins.guard_id = g.guard_id 
                                            LEFT JOIN site s ON ins.site_id = s.site_id
                                            WHERE ins.inspection_instance_id = ? ";

  public $queryGetInspectionQuestionDataById = "SELECT sg.*, q.question as question, sqa.answer as answer, sqa.inserted_date as askdate  FROM site_group sg
                                          RIGHT JOIN question_group qg ON sg.group_id = qg.group_id
                                          RIGHT JOIN question q ON qg.question_id = q.question_id
                                          RIGHT JOIN site_question_answer sqa ON q.question_id = sqa.question_id
                                          WHERE sg.site_id = ?
                                          ORDER BY sqa.inserted_date ASC";

  public $queryGetAllDocTypeList = "SELECT * FROM document_type";

  public $queryGetAllClientSiteData = "SELECT s.*, concat(c.first_name,' ',c.last_name) as client_name FROM site s
                                       LEFT JOIN customer c ON s.customer_id = c.customer_id";

  
/*
  public $queryGetInspInstDataByFilter = "SELECT ins.*,
                                                concat(u.first_name,' ',u.last_name) AS name,
                                                u.img_url AS image,
                                                concat(s.latitude,',',s.longitude) AS originpath,
                                                concat(ins.latitude,',',ins.longitude) AS destpath,
                                                sv.delta AS delta,
                                                sv.distance_to AS distance_to,
                                                s.address AS site_add,
                                                concat(c.first_name,' ',c.last_name) AS client_name,

                                        (SELECT delta FROM site_visiting WHERE user_id = u.user_id AND DATE(visiting_time) = DATE(ins.created_date) AND site_id = s.site_id ORDER BY visiting_time DESC LIMIT 1) as newDelta,	

                                        (SELECT COUNT(g.question_id) AS totalque
                                        FROM question_group g
                                        WHERE g.group_id = sg.group_id
                                        GROUP BY g.group_id) AS totalque,
                                                sg.group_id,

                                        (SELECT COUNT(qa.question_id) AS totalans
                                        FROM site_question_answer qa
                                        WHERE qa.inspection_instance_id = ins.inspection_instance_id
                                        GROUP BY qa.inspection_instance_id) AS totalans,
                                                s.latitude AS site_lat,
                                                 s.longitude AS site_long,

                                        (SELECT CONCAT(latitude,',',longitude) as lastlatlong FROM site_visiting WHERE user_id = u.user_id AND DATE(visiting_time) = DATE(ins.created_date) and visiting_time<sv.visiting_time ORDER BY visiting_time DESC LIMIT 1) as lastlatlong	
                                        , CONCAT(sv.latitude,',',sv.longitude) as destinationLatLong 

                                        FROM inspection_instance ins
                                        LEFT JOIN user u ON ins.created_by = u.user_id
                                        LEFT JOIN site s ON ins.site_id = s.site_id
                                        LEFT JOIN customer c ON s.customer_id = c.customer_id
                                        LEFT JOIN user_role ur ON ur.user_id = u.user_id
                                        LEFT JOIN site_visiting sv ON (u.user_id = sv.user_id
                                                                                                AND s.site_id=sv.site_id
                                                                                                AND date(sv.visiting_time)=date(ins.created_date))
                                        LEFT JOIN site_group sg ON s.site_id = sg.site_id
                                        WHERE DATE(ins.created_date) > (NOW() - INTERVAL 7 DAY)
                                        GROUP BY ins.inspection_instance_id
                                        ORDER BY sv.visiting_time DESC";

                                      //and DATE(ins.created_date) >= ? and DATE(ins.created_date) <= ? and s.site_id = ? and ur.role_id = ?
                      */
/*
  public $queryGetInspInstDataByFilter = "select s.site_title,concat(ue.first_name,' ',ue.last_name) as guard_name,
                                            concat(u.first_name,' ',u.last_name) as fo_name,concat(vu.first_name,' ',vu.last_name) as verified_by_name, u.img_url as fo_image,
                                            concat((select concat(last_v.latitude,',',last_v.longitude) from site_visiting last_v WHERE last_v.user_id = u.user_id
                                                 AND DATE(last_v.visiting_time) = DATE(sv.visiting_time)
                                                 AND last_v.visiting_time < sv.visiting_time AND last_v.employee_id IS NULL AND last_v.rejected_by IS NULL
                                                 ORDER BY last_v.visiting_time DESC LIMIT 1),'/',sv.latitude,',',sv.longitude) as map_link,
                                            (select count(qg.question_id) from `group` g1 
                                            LEFT JOIN question_group qg ON qg.group_id=g1.group_id 
                                            LEFT JOIN site_group sg ON qg.group_id=sg.group_id 
                                            WHERE s.site_id=sg.site_id OR (sv.employee_id IS NOT NULL AND g1.group_type=2 )
                                            ) as total_question,
                                            count(sqa.question_id) as total_answer, sv.* , s.latitude as site_lat, s.longitude as site_long, s.address AS site_add 
                                            from site_visiting sv
                                            INNER JOIN `user` u ON u.user_id=sv.user_id
                                            LEFT JOIN site s ON s.site_id=sv.site_id
                                            LEFT JOIN branch b ON b.branch_id=s.branch_id
                                            LEFT JOIN region r ON r.region_id=b.region_id
                                            LEFT JOIN site_question_answer sqa ON sqa.site_visiting_id=sv.site_visiting_id
                                            LEFT JOIN employee e ON e.employee_id=sv.employee_id
                                            LEFT JOIN `user` vu ON vu.user_id=sv.verified_by
                                            LEFT JOIN `user` ue ON ue.user_id=e.user_id
                                            where sv.employee_id IS NULL AND sv.rejected_by IS NULL #WHERE#
                                            group by sv.site_visiting_id 
                                            ORDER BY sv.user_id,sv.visiting_time DESC;";*/
  //AND ((last_v.custom='1' AND last_v.verified_by IS NOT NULL) OR last_v.custom='0')
  //AND ((last_v.custom='1' AND last_v.verified_by IS NOT NULL) OR last_v.custom='0')
  //DATE(DATE_SUB(NOW(),INTERVAL 7 DAY)) <= DATE(sv.visiting_time) AND
  
 
  public $queryGetInspInstDataByFilter = "SELECT s.site_title,concat(ue.first_name,' ',ue.last_name) as guard_name,
                                            concat(u.first_name,' ',u.last_name) as fo_name,concat(vu.first_name,' ',vu.last_name) as verified_by_name, u.img_url as fo_image,
                                            concat((select concat(last_v.latitude,',',last_v.longitude) from site_visiting last_v WHERE last_v.user_id = u.user_id
                                                 AND DATE(last_v.visiting_time) = DATE(sv.visiting_time)
                                                 AND last_v.visiting_time < sv.visiting_time AND last_v.employee_id IS NULL AND last_v.rejected_by IS NULL
                                                 ORDER BY last_v.visiting_time DESC LIMIT 1),'/',sv.latitude,',',sv.longitude) as map_link,
                                            (select count(qg.question_id) from `group` g1 
                                            LEFT JOIN question_group qg ON qg.group_id=g1.group_id 
                                            LEFT JOIN site_group sg ON qg.group_id=sg.group_id 
                                            WHERE s.site_id=sg.site_id OR (sv.employee_id IS NOT NULL AND g1.group_type=2 )
                                            ) as total_question,
                                            count(Distinct sqa.question_id) as total_answer, sv.* , if(s.latitude!='',s.latitude,0) as site_lat, if(s.longitude!='',s.longitude,0) as site_long, s.address AS site_add,s.city,s.zipcode, sv.site_id,com.delta_threshold_start, com.delta_threshold_end 
                                                from site_visiting sv
                                                INNER JOIN `user` u ON u.user_id=sv.user_id
                                                INNER JOIN `user_role` ur ON ur.user_id=u.user_id
                                                LEFT JOIN site s ON s.site_id=sv.site_id
                                                LEFT JOIN branch b ON b.branch_id=s.branch_id
                                                LEFT JOIN region r ON r.region_id=b.region_id
                                                LEFT JOIN site_question_answer sqa ON sqa.site_visiting_id=sv.site_visiting_id
                                                LEFT JOIN employee e ON e.employee_id=sv.employee_id
                                                LEFT JOIN `user` vu ON vu.user_id=sv.verified_by
                                                LEFT JOIN `user` ue ON ue.user_id=e.user_id
                                                LEFT JOIN `company` com ON com.company_id = u.company_id
                                                where sv.employee_id IS NULL AND sv.rejected_by IS NULL #WHERE# 
                                                group by sv.site_visiting_id 
                                                ORDER BY sv.user_id,sv.visiting_time DESC";
  
  public $queryGetRejectedInspectionsByFilter = "select s.site_title,concat(ue.first_name,' ',ue.last_name) as guard_name,
                                            concat(u.first_name,' ',u.last_name) as fo_name,concat(vu.first_name,' ',vu.last_name) as verified_by_name,concat(reu.first_name,' ',reu.last_name) as rejected_by_name, u.img_url as fo_image,
                                            concat((select concat(last_v.latitude,',',last_v.longitude) from site_visiting last_v WHERE last_v.user_id = u.user_id
                                                 AND DATE(last_v.visiting_time) = DATE(sv.visiting_time)
                                                 AND last_v.visiting_time < sv.visiting_time AND last_v.employee_id IS NULL AND last_v.rejected_by IS NULL
                                                 ORDER BY last_v.visiting_time DESC LIMIT 1),'/',sv.latitude,',',sv.longitude) as map_link,
                                            (select count(qg.question_id) from `group` g1 
                                            LEFT JOIN question_group qg ON qg.group_id=g1.group_id 
                                            LEFT JOIN site_group sg ON qg.group_id=sg.group_id 
                                            WHERE s.site_id=sg.site_id OR (sv.employee_id IS NOT NULL AND g1.group_type=2 )
                                            ) as total_question,
                                            count(Distinct sqa.question_id) as total_answer, sv.* , if(s.latitude!='',s.latitude,0) as site_lat, if(s.longitude!='',s.longitude,0) as site_long, s.address AS site_add,s.city,s.zipcode, sv.site_id 
                                                from site_visiting sv
                                                INNER JOIN `user` u ON u.user_id=sv.user_id
                                                INNER JOIN `user_role` ur ON ur.user_id=u.user_id
                                                LEFT JOIN site s ON s.site_id=sv.site_id
                                                LEFT JOIN branch b ON b.branch_id=s.branch_id
                                                LEFT JOIN region r ON r.region_id=b.region_id
                                                LEFT JOIN site_question_answer sqa ON sqa.site_visiting_id=sv.site_visiting_id
                                                LEFT JOIN employee e ON e.employee_id=sv.employee_id
                                                LEFT JOIN `user` vu ON vu.user_id=sv.verified_by
                                                LEFT JOIN `user` reu ON reu.user_id=sv.rejected_by
                                                LEFT JOIN `user` ue ON ue.user_id=e.user_id
                                                where sv.employee_id IS NULL AND sv.rejected_by IS NOT NULL #WHERE# 
                                                group by sv.site_visiting_id 
                                                ORDER BY sv.user_id,sv.visiting_time DESC";
  
  
  public $queryGetInspInstDataByFilterByCompanyId = "select s.site_title,concat(g.first_name,' ',g.last_name) as guard_name,
                                            concat(u.first_name,' ',u.last_name) as fo_name,concat(vu.first_name,' ',vu.last_name) as verified_by_name, u.img_url as fo_image,
                                            concat((select concat(last_v.latitude,',',last_v.longitude) from site_visiting last_v WHERE last_v.user_id = u.user_id
                                                 AND DATE(last_v.visiting_time) = DATE(sv.visiting_time)
                                                 AND last_v.visiting_time < sv.visiting_time AND last_v.guard_id IS NULL AND last_v.rejected_by IS NULL
                                                 ORDER BY last_v.visiting_time DESC LIMIT 1),'/',sv.latitude,',',sv.longitude) as map_link,
                                            (select count(qg.question_id) from `group` g1
                                            LEFT JOIN question_group qg ON qg.group_id=g1.group_id
                                            LEFT JOIN site_group sg ON qg.group_id=sg.group_id
                                            WHERE s.site_id=sg.site_id OR (sv.guard_id IS NOT NULL AND g1.group_type=2 )
                                            ) as total_question,
                                            count(sqa.question_id) as total_answer, sv.* , s.latitude as site_lat, s.longitude as site_long, s.address AS site_add
                                            from site_visiting sv
                                            INNER JOIN `user` u ON u.user_id=sv.user_id
  											LEFT JOIN user_role ur ON u.user_id = sv.user_id
                                            LEFT JOIN site s ON s.site_id=ur.site_id
                                            LEFT JOIN branch b ON b.branch_id=s.branch_id
                                            LEFT JOIN region r ON r.region_id=b.region_id
                                            LEFT JOIN site_question_answer sqa ON sqa.site_visiting_id=sv.site_visiting_id
                                            LEFT JOIN guard g ON g.guard_id=sv.guard_id
                                            LEFT JOIN `user` vu ON vu.user_id=sv.verified_by
                                            LEFT JOIN company c ON r.company_id = c.company_id
                                            where sv.guard_id IS NULL AND sv.rejected_by IS NULL #WHERE#
                                            group by sv.site_visiting_id
                                            ORDER BY sv.user_id,sv.visiting_time DESC;";
  
   
  public $queryGetGuardQuestionData = "SELECT q.* FROM `group` g
                                       INNER JOIN question_group qg ON g.group_id = qg.group_id
                                       INNER JOIN question q ON qg.question_id = q.question_id
                                       WHERE g.group_type = 2";
  
  public $queryGetGuardDataByCompanyId =  "SELECT c.company_name, 
                                            (SELECT group_concat(site_id) as site FROM `employee_site` Where employee_id = e.employee_id) as site_ids,
                                            e.employee_id as guard_id, u.company_id,u.first_name,u.last_name, u.phone,u.mobile,
                                            u.p_address as address, u.l_address as address1, u.zip ,
                                            (SELECT group_concat(q.qualification_name) FROM qualification q INNER JOIN employee_qualification eq ON q.qualification_id = eq.qualification_id AND q.is_qualification = 0 WHERE eq.employee_id = e.employee_id GROUP BY eq.employee_id) as education_qualification,
                                            (SELECT group_concat(q.qualification_name) FROM qualification q INNER JOIN employee_qualification eq ON q.qualification_id = eq.qualification_id AND q.is_qualification = 1 WHERE eq.employee_id = e.employee_id GROUP BY eq.employee_id) as technical_qualification,
                                            (SELECT group_concat(l.language_name) FROM languages l INNER JOIN employee_language el ON el.language_id  = l.language_id  WHERE el.employee_id = e.employee_id GROUP BY el.employee_id) as language_known ,e.status ,e.is_deleted,u.created_by, 
                                            IF(u.created_date = '0000-00-00 00:00:00',NULL,u.created_date) as created_date , u.qr_code 
                                            ,if(u.img_url!='',concat(?,'/',u.img_url),'') as img_url,e.company_employee_id,e.blood_group
                                        FROM `user` u
                                        LEFT JOIN user_role ur ON u.user_id = ur.user_id
                                        LEFT JOIN role r ON ur.role_id = r.role_id
                                        LEFT JOIN employee e ON u.user_id = e.user_id
                                        LEFT JOIN company c ON u.company_id = c.company_id
                                        WHERE r.code = 'GD' AND u.company_id = ? GROUP BY u.user_id";
  
  public $queryGetQuestionListByCompanyId =  "SELECT q.* FROM company c
                                        LEFT JOIN region r ON c.company_id = r.company_id
                                        LEFT JOIN branch b ON r.region_id = b.region_id
                                        LEFT JOIN site s ON b.branch_id = s.branch_id
                                        LEFT JOIN site_group sg ON s.site_id = sg.site_id
                                        LEFT JOIN question_group qg ON sg.group_id = qg.group_id
                                        LEFT JOIN question q ON qg.question_id = q.question_id
                                        WHERE c.company_id = 1";
          
  public $queryGetUserLatLongDataBySiteVisitingIdMin  = "SELECT site_visiting_id,latitude,
                                                            longitude
                                                     FROM site_visiting
                                                     WHERE user_id = ?
                                                       AND DATE(visiting_time) = DATE(?)
                                                       AND employee_id IS NULL
                                                       AND rejected_by IS NULL
                                                       AND site_visiting_id < ?
                                                     ORDER BY visiting_time DESC LIMIT 1";
  
    public $queryGetUserLatLongDataBySiteVisitingIdMax  = "SELECT site_visiting_id,latitude,
                                                            longitude
                                                     FROM site_visiting
                                                     WHERE user_id = ?
                                                       AND DATE(visiting_time) = DATE(?)
                                                       AND employee_id IS NULL
                                                       AND rejected_by IS NULL
                                                       AND site_visiting_id > ?
                                                     ORDER BY visiting_time ASC LIMIT 1";
  
  public $queryGetUserLatLongData   = "SELECT latitude,longitude FROM site_visiting WHERE user_id = ? AND DATE(visiting_time) = DATE(?) AND employee_id IS NULL ORDER BY visiting_time DESC LIMIT 1";

  public $queryGetLastLatLong       = "SELECT latitude,longitude FROM site_visiting WHERE user_id = ? AND DATE(visiting_time) = DATE(?) AND site_id IS NOT NULL ORDER BY visiting_time DESC LIMIT 1";
  
  public $queryGetConvayenceReport  = "SELECT c.company_name, CONCAT( s.address, ' ', s.city, ' ', s.zipcode ) AS site_add, concat( cus.first_name, ' ', cus.last_name ) AS customer_name, sv.latitude, sv.longitude, sv.visiting_time, sv.delta
                                        ,concat(u.first_name,' ',u.last_name) AS user_name
                                        FROM site_visiting sv
                                        INNER JOIN site s ON s.site_id = sv.site_id
                                        LEFT JOIN customer cus ON cus.customer_id = s.customer_id
                                        LEFT JOIN company c ON c.company_id = cus.company_id
                                        LEFT JOIN user u ON u.user_id = sv.user_id
                                        ORDER BY sv.visiting_time DESC
                                        LIMIT ?, ?";
  
  public $queryGetAllFieldOfficers  = "SELECT u.*, r.code as role_code FROM user u
                                          INNER JOIN user_role ur ON u.user_id = ur.user_id
                                          INNER JOIN role r ON ur.role_id = r.role_id
                                          WHERE r.code = 'FO' group by u.user_id";
  
  public $queryCheckFOStartDay  = "SELECT * FROM site_visiting sv
                                        LEFT JOIN user u ON u.user_id = sv.user_id
                                        WHERE sv.site_id IS NULL AND sv.employee_id IS NULL AND sv.custom = 0
                                        AND sv.user_id = ? AND DATE(sv.visiting_time) = DATE(?)  ";

  public $queryGetSurveyData   = "SELECT sv.site_visiting_id as svid, q.question, s.site_title as sitename,sv.custom,sv.description, 
                                s.address as s_address, concat(u.first_name,' ',u.last_name) as username,
                                  u.p_address as uadd,q.question_type,
                                  (SELECT sqa.answer FROM site_question_answer sqa
                                  WHERE sqa.site_visiting_id = sv.site_visiting_id AND sqa.question_id = q.question_id group by sqa.question_id)
                                  AS answer FROM site_visiting sv
                                  LEFT JOIN site s ON s.site_id = sv.site_id
                                  LEFT JOIN user u ON sv.user_id = u.user_id
                                  LEFT JOIN site_group sg ON sg.site_id = s.site_id
                                  LEFT JOIN question_group qg ON qg.group_id = sg.group_id
                                  LEFT JOIN question q ON qg.question_id = q.question_id
                                  WHERE sv.site_visiting_id = ?";
  
  
  public $queryGetGuardSurveyData = "SELECT q.question,tmp.* ,q.question_type
                                    FROM question q 
                                    INNER JOIN question_group qg ON q.question_id = qg.question_id
                                    INNER JOIN `group` g ON g.group_id=qg.group_id
                                    Left JOIN 
                                    (select sv.site_visiting_id as svid,  
                                    concat(u.first_name,' ',u.last_name) as username,
                                    concat(ue.first_name,' ',ue.last_name) as guardname,
                                    u.p_address as uadd,
                                    ue.p_address as guard_address,
                                    sqa.answer AS answer ,sqa.question_id from site_visiting sv 
                                    LEFT JOIN site_question_answer sqa ON sv.site_visiting_id = sqa.site_visiting_id
                                    LEFT JOIN user u ON sv.user_id = u.user_id
                                    LEFT JOIN employee e ON sv.employee_id = e.employee_id
                                    LEFT JOIN user ue ON e.user_id = ue.user_id
                                    WHERE sv.site_visiting_id = ?) tmp on tmp.question_id=q.question_id WHERE g.group_type   = 2";
  
  

  public $queryGetDrillDownConveyanceReport = "SELECT count(sv.site_id) as siteVisit, sum(sv.distance_to) as siteConvenc,s.site_id,                                              s.site_title,b.branch_id,b.branch_name,r.region_id,r.region_name,c.company_id,c.company_name
                                          from site_visiting sv
                                          LEFT JOIN `user` u ON u.user_id=sv.user_id
                                          LEFT JOIN site s ON s.site_id=sv.site_id
                                          LEFT JOIN branch b ON b.branch_id=s.branch_id
                                          LEFT JOIN region r ON r.region_id=b.region_id
                                          LEFT JOIN company c ON r.company_id=c.company_id
                                          LEFT JOIN `user` vu ON vu.user_id=sv.verified_by
                                          where sv.site_id IS NOT NULL AND month(sv.visiting_time)=month(NOW()) #WHERE#                                          
                                          GROUP BY s.site_id
                                          ORDER BY c.company_id,r.region_id,b.branch_id,s.site_id ASC";
  
  public $queryGetAllFieldOfficersByCompanyId = "SELECT u.*
                                     FROM user u 
                                     LEFT JOIN user_role ur ON ur.user_id = u.user_id
                                     LEFT JOIN site s ON s.site_id = ur.site_id
                                     LEFT JOIN branch b ON s.branch_id = b.branch_id
                                     LEFT JOIN customer c ON s.customer_id = c.customer_id
                                     LEFT JOIN company com ON com.company_id = c.company_id
                                     #WHERE# GROUP BY u.user_id";
  
  public $queryGetGuardInspectionList = "SELECT concat(ue.first_name,' ',ue.last_name) AS guard_name,
                                            concat(u.first_name,' ',u.last_name) AS fo_name,
                                            u.img_url AS fo_image,

                                       (SELECT count(qg.question_id)
                                        FROM `group` g1
                                        LEFT JOIN question_group qg ON qg.group_id=g1.group_id
                                        LEFT JOIN site_group sg ON qg.group_id=sg.group_id
                                        WHERE (sv.employee_id IS NOT NULL
                                               AND g1.group_type=2) ) AS total_question,
                                            count(sqa.question_id) AS total_answer,
                                            sv.*
                                     FROM site_visiting sv
                                     INNER JOIN user u ON u.user_id=sv.user_id
                                     LEFT JOIN employee e ON e.employee_id=sv.employee_id
                                     LEFT JOIN site_question_answer sqa ON sqa.site_visiting_id=sv.site_visiting_id
                                     LEFT JOIN `user` vu ON vu.user_id=sv.verified_by
                                     LEFT JOIN `user` ue ON ue.user_id=e.user_id
                                     WHERE sv.site_id IS NULL AND sv.employee_id IS NOT NULL 
                                       AND sv.custom = 0 #WHERE#
                                     GROUP BY sv.site_visiting_id
                                     ORDER BY sv.visiting_time DESC LIMIT ?, ?";
  
  public $queryGetSkillDetailById = "SELECT * FROM  employee WHERE user_id = ?";
    //DATE_FORMAT(concat(?,' ', shift_time), '%Y-%m-%d %H:%i:%s')
  
  public $queryGetExperienceDetailByEmployeeId = 'SELECT ee.*, c.company_name ,
                                                   FLOOR(TIMESTAMPDIFF(YEAR, ee.start_date, ee.end_date)) AS exp_duration_year,
                                                   MOD(TIMESTAMPDIFF(MONTH, ee.start_date, ee.end_date),12) AS exp_duration_month
                                                    FROM employee_experience ee
                                                    INNER JOIN company c ON ee.company_id = c.company_id
                                                    WHERE ee.employee_id = ?';
  
  public $queryGetReviewDataByEmployeeId = "SELECT r.*, concat(u.first_name,' ',u.last_name) AS fo_name,
                                            if(u.img_url!='',concat(?,'/',u.img_url),'') as img_url
                                            FROM review r
                                            LEFT JOIN employee e ON r.employee_id = e.employee_id 
                                            LEFT JOIN `user` u ON u.user_id =   r.review_by
                                            WHERE r.employee_id = ?";
  
  public $queryGetAvgReviewRatingByEmployeeId = "SELECT  if(avg(r.rating)!='',avg(r.rating),0) as avg_rating
                                            FROM review r
                                            LEFT JOIN employee e ON r.employee_id = e.employee_id 
                                            LEFT JOIN `user` u ON u.user_id =   r.review_by
                                            WHERE r.employee_id = ?";
  
  public $queryGetRatingDataByEmployeeId    = "SELECT if(avg(er.discipline)!='',avg(er.discipline),0) as discipline_rating ,
                                                      if(avg(er.punctuality)!='',avg(er.punctuality),0) as punctuality_rating ,
                                                      if(avg(er.fitness)!='',avg(er.fitness),0) as fitness_rating ,
                                                      if(avg(er.cleverness)!='',avg(er.cleverness),0) as cleverness_rating,
                                                      if(avg(er.cleanliness)!='',avg(er.cleanliness),0) as cleanliness_rating 
                                            FROM employee_rating er
                                            LEFT JOIN employee e ON er.employee_id = e.employee_id 
                                            LEFT JOIN `user` u ON u.user_id =   er.rating_by
                                            WHERE er.employee_id = ?";
  
  public $queryGetSkillDetailByEmployeeId = "SELECT es.*, s.skill_name FROM employee_skill es
                                                  LEFT JOIN skills s ON es.skill_id = s.skill_id
                                                  WHERE es.employee_id = ?";
  
  public $queryGetQualificationList = "SELECT * FROM qualification WHERE status =1 AND is_qualification = ?";
  
  public $queryDelQualification = "DELETE eq FROM employee_qualification eq
                                   LEFT JOIN qualification q ON eq.qualification_id = q.qualification_id
                                   WHERE eq.employee_id = ? AND q.is_qualification = ?";
  
  public $queryGetQualificationByEmployeeId  = "SELECT eq.employee_id,eq.qualification_id,eq.employee_id,q.qualification_name,q.is_qualification
                                                FROM employee_qualification eq
                                                INNER JOIN qualification q ON eq.qualification_id = q.qualification_id AND q.status = 1
                                                WHERE employee_id = ? ORDER BY q.is_qualification ASC";
  
  public $queryGetAllLanguages = "SELECT * FROM languages WHERE status = 1";
  
  public $queryGetLanguageDetailByEmployeeId = "SELECT el.*, l.language_name
                                                FROM employee_language el
                                                INNER JOIN languages l ON el.language_id = l.language_id AND l.status = 1
                                                WHERE el.employee_id = ?";
  
  public $queryGetUserByUserIdPassword  = "SELECT u.* FROM user u WHERE u.user_id = ? AND u.password = ? ";
  
  public $queryCheckEmailForForgotPassword  = "SELECT u.* FROM user u WHERE u.email = ?";
  
  public $queryGetUserByEmail   = "SELECT u.* FROM user u WHERE u.email = ?";
  
  public $queryGetAllEmployeeExperienceListById = "SELECT ee.*,
                                                        c.company_name,
                                                        concat(u.first_name,' ',u.last_name) AS name,
                                                        concat(uv.first_name,' ',uv.last_name) AS verified_name,
                                                        TIMESTAMPDIFF(YEAR, ee.start_date, ee.end_date) AS exp_duration_year,
                                                        TIMESTAMPDIFF(MONTH, ee.start_date, ee.end_date) AS exp_duration_month
                                                 FROM employee_experience ee
                                                 INNER JOIN employee e ON ee.employee_id = e.employee_id
                                                 INNER JOIN company c ON ee.company_id = c.company_id
                                                 LEFT JOIN user u ON e.user_id = u.user_id
                                                 LEFT JOIN user uv ON ee.verified_by = uv.user_id
                                                 WHERE ee.company_id = ?
                                                 ORDER BY ee.employee_id ASC LIMIT ?, ?";
  
  public $queryDeleteExperienceByEmployeeId     = "DELETE FROM employee_experience WHERE employee_id = ? AND verified_by IS NULL";
  
  public $queryCheckEmployeeId  = "SELECT * FROM employee where company_employee_id = ?";
  
  public $queryCheckSiteidId    = "SELECT * FROM site where company_site_id = ?";


  public $querygetCompanyAdminEmailIdsByFo="SELECT u.email 
  FROM user u 
  INNER JOIN user_role ur on u.user_id=ur.user_id
  INNER JOIN role r on r.role_id=ur.role_id
  WHERE r.code='cadmin' AND ur.company_id=?";

  public $querygetsiteNameScanByFO="SELECT c.first_name,s.customer_id,s.site_title,
  s.address,s.city,s.state,IF(c.email != '',c.email,'') as customer_email 
  FROM site s 
  INNER JOIN customer c on c.customer_id=s.customer_id 
  WHERE s.site_id=?";

  public $querygetsiteNameScanByFOForCustmer="SELECT c.first_name,s.customer_id,s.site_title,
  s.address,s.city,s.state,IF(c.email != '',c.email,'') as customer_email 
  FROM site s 
  INNER JOIN customer c on c.customer_id=s.customer_id   
  WHERE s.site_id=? and c.is_company_notification_send=1";

  public $querygetQuestionAnsForClientEmail = "SELECT sqa.question_text,sqa.answer
  FROM site_question_answer sqa  
  WHERE sqa.site_visiting_id = ?";

}?>
