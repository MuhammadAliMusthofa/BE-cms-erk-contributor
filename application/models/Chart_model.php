<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart_model extends CI_Model{
    
	function risk_yearly(){
                $y=date('Y');
		$q="SELECT count(*) as `all` FROM sv_risk_data WHERE YEAR(tgl_register)='$y' ";
		$a=$this->db->query($q)->row();
                return $a->all;
	}
        
	function risk_severity(){
                $y=date('Y');
		$q1="SELECT count(a.id) as `all` FROM sv_risk_data a LEFT JOIN sv_assessment_formula b ON a.rr_assessment=b.id WHERE YEAR(tgl_register)='$y' AND b.assessment=1 ";
		$q2="SELECT count(a.id) as `all` FROM sv_risk_data a LEFT JOIN sv_assessment_formula b ON a.rr_assessment=b.id WHERE YEAR(tgl_register)='$y' AND b.assessment=2 ";
		$q3="SELECT count(a.id) as `all` FROM sv_risk_data a LEFT JOIN sv_assessment_formula b ON a.rr_assessment=b.id WHERE YEAR(tgl_register)='$y' AND b.assessment=3 ";
		$a1=$this->db->query($q1)->row_array();
		$a2=$this->db->query($q2)->row_array();
		$a3=$this->db->query($q3)->row_array();
                $arr=array(
                    1=>$a1['all'],
                    2=>$a2['all'],
                    3=>$a3['all']
                        );
                return $arr;
	}
        function risk_weekly($datss){
                $y=date('Y');
		$q="SELECT count(*) as `all` FROM sv_risk_data WHERE tgl_register='$datss' ";
		$a=$this->db->query($q)->row();
                return $a->all;
	}

	function getCustomerData() {
        $queryCustomers = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_users WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)');
        return $queryCustomers->result();
    }

	function getRedeemData(){
		$queryRedeem = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_redeem_history WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data redeem
		return $queryRedeem->result();
	}

	function getVideoData(){
		$queryVideo = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_videos WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data video
		return $queryVideo->result();
	}

	function getPaymentData(){
		$queryPayment = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_payment_details WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data video
		return $queryPayment->result();
	}

	// Payment
	public function getCountByConsumer($consumerType) {
        $query = $this->db->query("SELECT COUNT(*) AS count FROM sv_payment WHERE consumer = ?", array($consumerType));
        $result = $query->row();
        return $result->count;
    }

	public function getCountByActivation($activationType) {
        $query = $this->db->query("SELECT COUNT(*) AS count FROM sv_user_packages WHERE activation = ?", array($activationType));
        $result = $query->row();
        return $result->count;
    }

	public function getLimitedAdminsWithGroupTitle($limit = 4) {
        $query = $this->db->query('
            SELECT sv_admin.*, sv_admin_grup.title, sv_admin.status
            FROM sv_admin
            INNER JOIN sv_admin_grup ON sv_admin.id_admin_grup = sv_admin_grup.id
            LIMIT ?', array($limit)
        );
        return $query->result();
    }
    

	public function getTotalPrice() {
        $query = $this->db->query('SELECT SUM(price) AS total_price FROM sv_user_packages');
        return $query->row();
    }

	public function getTotalPriceTransaksi() {
        $query = $this->db->query('SELECT SUM(price) AS total_price FROM sv_user_packages');
        return $query->row();
    }

	public function getTotalVideosCount() {
        $query = $this->db->query('SELECT * FROM sv_videos');
        return $query->num_rows();
    }

    public function getUsersCount() {
        $query = $this->db->query('SELECT * FROM sv_users');
        return $query->num_rows();
    }

    public function getPackagesCount() {
        $query = $this->db->query('SELECT * FROM sv_packages');
        return $query->num_rows();
    }

    public function getPaymentCount() {
        $query = $this->db->query('SELECT * FROM sv_payment');
        return $query->num_rows();
    }

    public function getUsersWithPackageCount() {
        $query = $this->db->query('
            SELECT up.uid, COUNT(up.uid) AS total_uid, u.full_name
            FROM sv_user_packages up
            LEFT JOIN sv_users u ON up.uid = u.id
            GROUP BY up.uid
            ORDER BY COUNT(up.uid) DESC
            LIMIT 9
        ');

        return $query->result();
    }

    public function getUsersWithTotalPrice() {
        $query = $this->db->query('
            SELECT up.uid, SUM(up.price) AS total_price, u.full_name
            FROM sv_user_packages up
            LEFT JOIN sv_users u ON up.uid = u.id
            GROUP BY up.uid, u.full_name
            ORDER BY SUM(up.price) DESC
            LIMIT 9
        ');

        return $query->result();
    }

    public function getPackageWithTotalPrice() {
        $query = $this->db->query('
                SELECT up.package_id, COUNT(up.package_id) AS total_package_id, u.name
                FROM sv_user_packages up
                LEFT JOIN sv_packages u ON up.package_id = u.id
                GROUP BY up.package_id
                ORDER BY COUNT(up.package_id) DESC
                LIMIT 5
        ');

        return $query->result();
    }

    // public function getPackageWithTotalPriceSchool() {
    //     $this->db->select('up.package_id, COUNT(up.package_id) AS total_package_id, pkg.name AS package_name, usr.name AS user_name, usr.school');
    //     $this->db->from('sv_user_packages up');
    //     $this->db->join('sv_packages pkg', 'up.package_id = pkg.id', 'left');
    //     $this->db->join('sv_users usr', 'up.uid = usr.id', 'left');
    //     $this->db->group_by('up.package_id, pkg.name, usr.name, usr.school');
    //     $this->db->order_by('total_package_id', 'DESC');
    //     $this->db->limit(5);
    
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function getUserPackages() {
        $this->db->select('UP.uid, U.full_name, UP.package_id, P.name');
        $this->db->from('SV_USER_PACKAGES AS UP');
        $this->db->join('SV_USERS AS U', 'U.full_name = UP.uid');
        $this->db->join('SV_PACKAGES AS P', 'P.name = UP.package_id');
        $this->db->order_by('UP.uid', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPackageDataTables() {
        return $this->db->get('sv_user_packages')->result();
    }

    public function getAllUserPackages() {
        $this->db->select('up.package_id, up.createdAt, up.expiredAt, u.name, u.price, su.school, su.full_name, su.email');
        $this->db->from('sv_user_packages up');
        $this->db->join('sv_packages u', 'up.package_id = u.id', 'left');
        $this->db->join('sv_users su', 'up.uid = su.id', 'left');
        $this->db->order_by('su.full_name', 'ASC');
        return $this->db->get()->result();
    }

    public function getTopUsers() {
        $query = $this->db->query('
            SELECT up.uid, COUNT(up.uid) AS total_uid, u.full_name
            FROM sv_user_packages up
            LEFT JOIN sv_users u ON up.uid = u.id
            GROUP BY up.uid
            ORDER BY COUNT(up.uid) DESC
            LIMIT 7
        ');
        return $query->result();
    }

    public function getTopUsersWithTotalPrice() {
        $query = $this->db->query('
            SELECT up.uid, SUM(up.price) AS total_price, u.full_name
            FROM sv_user_packages up
            LEFT JOIN sv_users u ON up.uid = u.id
            GROUP BY up.uid, u.full_name
            ORDER BY SUM(up.price) DESC
            LIMIT 7
        ');
        return $query->result();
    }

    public function getTopRedeem() {
        $query = $this->db->query('
            SELECT rh.redeemBy, u.full_name, COUNT(*) AS jumlah_data
            FROM sv_redeem_history rh
            JOIN sv_users u ON rh.redeemBy = u.id
            GROUP BY rh.redeemBy, u.full_name
            ORDER BY jumlah_data DESC 
            LIMIT 5
        ');
        return $query->result();
    }

    public function getTopPackageRedeem() {
        $query = $this->db->query('
            SELECT rh.package_id, u.name, COUNT(*) AS jumlah_data
            FROM sv_redeem_history rh
            JOIN sv_packages u ON rh.package_id = u.id
            GROUP BY rh.package_id, u.name
            ORDER BY jumlah_data DESC
            LIMIT 5
        ');
        return $query->result();
    }

    public function getTopRedeemWithTotalPrice() {
        $query = $this->db->query('
            SELECT u.full_name, COUNT(rh.redeemBy) AS jumlah_data, SUM(rh.price) AS total_price
            FROM sv_redeem_history rh
            JOIN sv_users u ON rh.redeemBy = u.id
            GROUP BY u.full_name
            ORDER BY jumlah_data DESC
            LIMIT 5
        ');
        return $query->result();
    }

    public function getTopPackageRedeemWithTotalPrice() {
        $query = $this->db->query('
            SELECT u.name, COUNT(rh.redeemBy) AS jumlah_data, SUM(rh.price) AS total_price
            FROM sv_redeem_history rh
            JOIN sv_packages u ON rh.package_id = u.id
            GROUP BY u.name
            ORDER BY jumlah_data DESC
            LIMIT 5
        ');
        return $query->result();
    }

    public function getUserHistory() {
        $query = $this->db->query('
            SELECT sv_user_history.*, sv_users.full_name
            FROM sv_user_history
            INNER JOIN sv_users ON sv_user_history.uid = sv_users.id
            ORDER BY sv_user_history.updatedAt DESC 
            LIMIT 20
        ');
        return $query->result();
    }

    public function getLogUserHistory() {
        $this->db->select('sv_user_history.*, sv_users.full_name');
        $this->db->from('sv_user_history');
        $this->db->join('sv_users', 'sv_user_history.uid = sv_users.id', 'inner');
        $this->db->order_by('sv_user_history.id', 'ASC');
    
        return $this->db->get()->result();
    }

    public function getPaymentAll() {
        $this->db->select('spp.transaction_status, spp.settlement_time, spp.updatedAt, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        // $this->db->order_by('spp.updatedAt', 'ASC');
        
        return $this->db->get()->result();
    }
    public function getPaymentSettlement() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['settlement']);
        
        return $this->db->get()->result();
    }
    public function getPaymentRefound() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['refound']);
        
        return $this->db->get()->result();
    }
    public function getPaymentCancel() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['cancel']);
        
        return $this->db->get()->result();
    }
    // public function getPaymentExpired() {
    //     $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
    //     $this->db->from('sv_payment spp');
    //     $this->db->join('sv_users svu', 'spp.uid = svu.id');
    //     $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
    //     $this->db->where_in('spp.transaction_status', ['expired']);
        
    //     return $this->db->get()->result();
    // }
    public function getPaymentPending() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['pending']);
        
        return $this->db->get()->result();
    }
    
    public function sdsdsd() {
        $this->db->select('transaction_status, COUNT(*) AS total_count');
            $this->db->from('sv_payment');
            $this->db->group_by('transaction_status');
            $this->db->get();

            return $this->db->get()->result();
    }

    public function countByTransactionStatus($transaction_status) {
        $query = $this->db->query("SELECT COUNT(*) AS count FROM sv_payment WHERE transaction_status = ?", array($transaction_status));
        $result = $query->row();
        return $result->count;
    }

    public function countByPlatform($platform) {
        $query = $this->db->query("SELECT COUNT(*) AS count FROM sv_payment WHERE platform = ?", array($platform));
        $result = $query->row();
        return $result->count;
    }

    public function getCountPerId() {
        $this->db->select('transaction_status, COUNT(*) AS count_per_status');
        $this->db->from('sv_payment');
        $this->db->group_by('transaction_status');

        return $this->db->get()->result();
    }

    public function getTopPackages() {
        $this->db->select('sv_payment.package_id, sv_packages.name, COUNT(*) AS total_data');
        $this->db->from('sv_payment');
        $this->db->join('sv_packages', 'sv_payment.package_id = sv_packages.id', 'inner');
        $this->db->group_by('sv_payment.package_id, sv_packages.name');
        $this->db->order_by('total_data', 'DESC');
    
        return $this->db->get()->result();
    }

    public function getVisitsByDate($day, $month, $year){
        $start_date = "$year-$month-$day 00:00:00";
        $end_date = "$year-$month-$day 23:59:59";

        $this->db->select('*');
        $this->db->from('sv_user_history');
        $this->db->where('updatedAt >=', $start_date);
        $this->db->where('updatedAt <=', $end_date);
        $this->db->order_by('updatedAt', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }
    public function getVisitsToday(){
        $today = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('sv_user_history');
        $this->db->where('DATE(updatedAt)', $today);
        $this->db->order_by('updatedAt', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getVisitsThisMonth(){
        $thisMonth = date('Y-m');
        $this->db->select('*');
        $this->db->from('sv_user_history');
        $this->db->where('DATE_FORMAT(updatedAt, "%Y-%m")', $thisMonth);
        $this->db->order_by('updatedAt', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getVisitsThisYear(){
        $thisYear = date('Y');
        $this->db->select('*');
        $this->db->from('sv_user_history');
        $this->db->where('YEAR(updatedAt)', $thisYear);
        $this->db->order_by('updatedAt', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function countDataThisToday() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('sv_user_history');
        $this->db->where('MONTH(updatedAt)', date('d'));
        $this->db->where('MONTH(updatedAt)', date('m'));
        $this->db->where('YEAR(updatedAt)', date('Y'));

        $query = $this->db->get();
        return $query->row()->total;
    }

    public function countDataThisMonth() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('sv_user_history');
        $this->db->where('MONTH(updatedAt)', date('m'));
        $this->db->where('YEAR(updatedAt)', date('Y'));

        $query = $this->db->get();
        return $query->row()->total;
    }
    public function countDataThisYears() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('sv_user_history');
        $this->db->where('YEAR(updatedAt)', date('Y'));

        $query = $this->db->get();
        return $query->row()->total;
    }

    public function get_videos() {
        $this->db->select('*');
        $this->db->from('sv_videos');
        return $this->db->get()->result();
    }

    public function get_video($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('sv_videos');
        return $query->row_array();
    }
    public function get_worksheet($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('sv_videos');
        return $query->row_array();
    }

    public function update_video($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('sv_videos', $data);
    }

    public function get_video_by_id($id) {
        $this->db->select('video_id');
        $this->db->where('id', $id);
        $query = $this->db->get('sv_videos');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_videos_with_labels() {
        $this->db->select('sv_videos.*, sv_video_labels.*');
        $this->db->from('sv_videos');
        $this->db->join('sv_video_labels', 'sv_video_labels.vid = sv_videos.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_videos_with_labels_combined_LABEL() {
        $this->db->select('a.id, a.ingest_status_id,  a.file_worksheet, a.video_id, a.name_id, a.createdAt, a.publish, GROUP_CONCAT(c.label) as labels');
        $this->db->from('sv_videos a');
        $this->db->join('sv_video_labels b', 'b.vid = a.id');
        $this->db->join('sv_labels c', 'c.id = b.label_id');
        $this->db->group_by('a.id');
        return $this->db->get()->result();
    }
    public function get_videos_with_labels_combined() {
        $this->db->select('a.id, a.ingest_status_id,  a.file_worksheet, a.video_id, a.name_id, a.createdAt, a.publish, a.caption_id, a.thumbnail_id, a.filename_id, a.poster_id, GROUP_CONCAT(c.tags) as tags');
        $this->db->from('sv_videos a');
        $this->db->join('sv_video_tags b', 'b.vid = a.id');
        $this->db->join('sv_tags c', 'c.id = b.tag_id');
        $this->db->group_by('a.id');
        return $this->db->get()->result();
    }
    
    public function get_packages_with_labels() {
        $this->db->select('sv_packages.*, sv_labels.label_name');
        $this->db->from('sv_packages');
        $this->db->join('sv_labels', 'sv_labels.id = sv_packages.jenjang_id');
        $query = $this->db->get();

        return $query->result();
    }
    
    public function get_packages_all() {
        $query = $this->db->get('sv_packages');
        return $query->result();
    }

    public function get_packages() {
        $this->db->where('device IS NOT NULL')
                 ->where('kode_produk_ax IS NOT NULL')
                 ->where('periode !=', 0)
                 ->where('deletedAt IS NULL');
                
        $query = $this->db->get('sv_packages');
        
        return $query->result();
    }
    
    
    public function getVouchers() {
        $query = $this->db->get('sv_vouchers');
        return $query->result();
    }
    public function getListVoucher() {
        $this->db->select('v.*, u.email, u.full_name, o.order_id, vj.title, vj.package_name');
        $this->db->from('sv_vouchers v');
        $this->db->join('sv_users u', 'u.id = v.uid', 'left');
        $this->db->join('sv_voucher_job vj', 'vj.id = v.package_id', 'left');
        $this->db->join('sv_payment o', 'o.id = v.payment_id', 'left');
       
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    
    public function getContents() {
        $query = $this->db->get('sv_contents');
        return $query->result();
    }

    public function getGames() {
        $query = $this->db->get('sv_games');
        return $query->result();
    }

    public function getOnboard() {
        $query = $this->db->get('sv_onboard');
        return $query->result();
    }

    public function getCapaianPembelajaran() {
        $query = $this->db->get('sv_capaian_pembelajaran');
        return $query->result();
    }

    public function get_all_cp() {
        return $this->db->get('sv_capaian_pembelajaran')->result();
    }   

    public function getJenjangOptions() {
        $query = $this->db->query("SHOW COLUMNS FROM sv_capaian_pembelajaran WHERE Field = 'jenjang'");
        $row = $query->row();
        
        $enum_list = explode("','", substr($row->Type, 6, -2));
        return $enum_list;
    }

    public function add_cp($data) {
        return $this->db->insert('sv_capaian_pembelajaran', $data);
    }
    
    public function get_cp_by_id($id) {
        $query = $this->db->get_where('sv_capaian_pembelajaran', array('id' => $id));
        return $query->row_array();
    }

    public function update_cp($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('sv_capaian_pembelajaran', $data);
    }

    public function delete_cp($id) {
        return $this->db->delete('sv_capaian_pembelajaran', array('id' => $id));
    }

    public function savePdfToDb($link, $judul, $deskripsi) {
        $insert_data = array(
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'link' => $link, // Simpan nama file ke field 'link'
            // 'uploadBy' => $uploadBy,
            'createdAt' => date('Y-m-d H:i:s')
            // Tambahkan field lain yang diperlukan sesuai kebutuhan
        );

        return $this->db->insert('sv_capaian_pembelajaran', $insert_data);
    }


    public function getAllMenu() {
        $this->db->select('m.*, COALESCE(parents_menu.title, "") AS id_parents_title, m.title, adm.name');
        $this->db->from('sv_menu m');
        $this->db->join('sv_menu parents_menu', 'm.id_parents = parents_menu.id', 'left');
        $this->db->join('sv_admin adm', 'adm.id = m.create_user_id', 'left');
        $query = $this->db->get();
        return $query->result();

    }

    public function getAllAdminManagement() {
        $this->db->select('a.*, ag.title');
        $this->db->from('sv_admin a');
        $this->db->join('sv_admin_grup ag', 'ag.id = a.id_admin_grup', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getAdminGroup() {
        $this->db->select('ag.*, a.name');
        $this->db->from('sv_admin_grup ag');
        $this->db->join('sv_admin a', 'a.id = ag.create_user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    
    

    public function getPaymentDetails() {
        $this->db->select('p.*, u.email, u.full_name'); // Pilih kolom yang diinginkan
        $this->db->from('sv_payment as p');
        $this->db->join('sv_users as u', 'p.uid = u.id', 'left');
        // $this->db->join('sv_payment_details as pd', 'p.uid = pd.id', 'left');
        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil dalam bentuk array objek
    }

    public function getUserPackage() {
        $this->db->select('up.*, u.full_name, u.email, p.name');
        $this->db->from('sv_user_packages as up');
        $this->db->join('sv_users as u', 'u.id = up.uid', 'left');
        $this->db->join('sv_packages as p', 'p.id = up.package_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    // public function getJobGenerate() {
    //     $query = $this->db->get('sv_voucher_job');
    //     return $query->result();
    // }
    public function getJobGenerate() {
        $this->db->select('vj.*, adm.name');
        $this->db->from('sv_voucher_job as vj');
        $this->db->join('sv_admin as adm', 'adm.id = vj.createdBy');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllCustomers() {
        $this->db->select('u.*, ut.title_id, ct.city_name, prov.prov_name');
        $this->db->from('sv_users u');
        $this->db->join('sv_users_type as ut', 'ut.id = u.user_type', 'left');
        $this->db->join('sv_cities as ct', 'ct.id = u.city', 'left');
        $this->db->join('sv_provinces as prov', 'prov.id = u.province', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllRedeem() {
        $this->db->select('rh.*, usr.full_name');
        $this->db->from('sv_redeem_history as rh');
        $this->db->join('sv_users as usr', 'usr.id = rh.redeemBy');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getLatestVideos() {
        $query = $this->db->query('SELECT * FROM sv_videos ORDER BY createdAt DESC, thumbnail_id, name_id, description_id DESC LIMIT 3');
        return $query->result();
    }

    public function getVouch() {
        $this->db->select('v.*, v.expiredAt, u.email, u.full_name, o.order_id, vj.title, vj.package_name');
        $this->db->from('sv_vouchers v');
        $this->db->join('sv_users u', 'u.id = v.uid', 'left');
        $this->db->join('sv_voucher_job vj', 'vj.id = v.package_id', 'left');
        $this->db->join('sv_payment o', 'o.id = v.payment_id', 'left');
       
        $query = $this->db->get();
        
        return $query->result();
    }
    public function getVouchExp() {
        $today = date('Y-m-d'); // Tanggal hari ini
        $threeDaysLater = date('Y-m-d', strtotime('+3 days')); // Tanggal 3 hari ke depan
        $this->db->select('v.*, v.expiredAt, u.email, u.full_name, o.order_id, vj.title, vj.package_name');
        $this->db->from('sv_vouchers v');
        $this->db->join('sv_users u', 'u.id = v.uid', 'left');
        $this->db->join('sv_voucher_job vj', 'vj.id = v.package_id', 'left');
        $this->db->join('sv_payment o', 'o.id = v.payment_id', 'left');
        $this->db->where('v.expiredAt >', $today); // Filter untuk expiredAt setelah hari ini
        $this->db->where('v.expiredAt <=', $threeDaysLater); // Filter untuk expiredAt kurang dari atau sama dengan 3 hari dari sekarang
        $query = $this->db->get();
        
        return $query->result();
    }

    public function getPay() {
        $this->db->select('spp.* , svu.full_name, svu.email, pck.name, pck.periode');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_packages pck', 'spp.package_id = pck.id');
        return $this->db->get()->result();
    }

    public function getCust() {
        $this->db->select('u.*, ut.title_id, ct.city_name, prov.prov_name');
        $this->db->from('sv_users u');
        $this->db->join('sv_users_type as ut', 'ut.id = u.user_type', 'left');
        $this->db->join('sv_cities as ct', 'ct.id = u.city', 'left');
        $this->db->join('sv_provinces as prov', 'prov.id = u.province', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getVideos() {
        $this->db->select('a.id, a.ingest_status_id, a.video_id, a.name_id, a.createdAt, a.file_worksheet, a.publish, a.caption_id, a.thumbnail_id, a.filename_id, a.poster_id, a.repository, a.project, GROUP_CONCAT(c.tags) as tags');
        $this->db->from('sv_videos a');
        $this->db->join('sv_video_tags b', 'b.vid = a.id');
        $this->db->join('sv_tags c', 'c.id = b.tag_id');
        $this->db->group_by('a.id');
        $this->db->order_by('a.createdAt', 'desc');
        return $this->db->get()->result();
    }

    public function update_transaction($id, $datatr) {
        $this->db->where('id', $id);
        $this->db->update('sv_payment', $datatr);
    }
    public function manualactivation($id, $datausr)
    {
        $query = $this->db->query("
            UPDATE sv_user_packages
            SET
                uid = '{$datausr['uid']}',
                package_id = '{$datausr['package_id']}',
                price = '{$datausr['price']}',
                createdAt = '{$datausr['createdAt']}',
                expiredAt = UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME('{$datausr['createdAt']}'), INTERVAL {$datausr['periode']} DAY))
            WHERE id = {$id}
        ");

        return $query;
    }
    public function userpakage_transaction($data) {
        return $this->db->insert('sv_user_packages', $data);
    }

    public function getPaymentExpired() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['expired']);
        
        return $this->db->get()->result();
    }

    public function getExpiredCount() {
        $threeDaysAhead = date('Y-m-d', strtotime('+3 days')); // Tanggal 3 hari ke depan
        $this->db->select('COUNT(*) as count');
        $this->db->from('sv_vouchers');
        $this->db->where('expiredAt <=', $threeDaysAhead);
        $this->db->where('expiredAt >=', date('Y-m-d')); // Pastikan kita hanya menghitung yang akan kedaluwarsa, bukan yang sudah kedaluwarsa
        $query = $this->db->get();
        return $query->row()->count; // Mengambil jumlah data dari hasil query
    }
    

    public function approachingExpiredCount() {
        $threeDaysLater = date('Y-m-d', strtotime('+3 days')); // Tanggal 3 hari dari sekarang
        $this->db->select('COUNT(*) as count');
        $this->db->from('sv_vouchers');
        $this->db->where('expiredAt <=', $threeDaysLater);
        $query = $this->db->get();
        $result = $query->row();
        return $result->count;
    }
    public function getRecordById($id) {
        // Lakukan query untuk mengambil data berdasarkan ID
        $query = $this->db->get_where('sv_vouchers', array('id' => $id));
        return $query->row_array();
    }

    public function updateRecord($id, $data) {
        // Lakukan query untuk mengupdate data berdasarkan ID
        $this->db->where('id', $id);
        $this->db->update('sv_vouchers', $data);
    }
    public function get_android() {
        $this->db->where('type', 'android');
        $this->db->order_by('createdAt', 'desc');
        return $this->db->get('sv_mobile')->result();
    }
    public function get_ios() {
        $this->db->where('type', 'ios');
        $this->db->order_by('createdAt', 'desc');
        return $this->db->get('sv_mobile')->result();
    }

    public function add_version($data) {
        $this->db->insert('sv_mobile', $data);
    }

    public function delete_ver($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sv_mobile');
        return $this->db->affected_rows() > 0;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

