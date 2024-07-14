<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_user');
    $this->load->model('m_event');
  }

  public function index()
  {
    sedangLogout();
    $time = time();
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $wel = $this->db->get_where('welcome', ['event_id' => $event['id']])->row_array();
    $this->db->set('sapa', 0)->where(['event_id' => $event['id'], 'timer <' => $time])->update('tamu');
    $data['wel'] = $wel;
    $data['user'] = $user;
    $data['title'] = base_url();
    $this->load->view('home/layar_sapa', $data);
  }

  public function welcome_view()
  {
    sedangLogout();
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $wel = $this->db->get_where('welcome', ['event_id' => $event['id']])->row_array();
    $data['wel'] = $wel;
    $data['user'] = $user;
    $data['icon'] = 'logo.png';
	$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('home/welcome_view', $data);
  }

  public function autoLoadPage()
  {
    $time = time();
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $wel = $this->db->get_where('welcome', ['event_id' => $event['id']])->row_array();
    $this->db->set('sapa', 0)->where(['event_id' => $event['id'], 'timer <' => $time])->update('tamu');
    $tamu = $this->db->get_where('tamu', ['event_id' => $event['id'], 'sapa' => 1])->row_array();

    if (!$this->session->userdata('loginAksesNewImam')) {
      $data = '<div style="width: 100vw;height: 100vh; background-color: #000;padding-top:25vh;text-align:center" id="bgImg">';
      $data .= '<div class="row">';
      $data .= '<div class="col-sm-12"><h5 style="font-size: 7vw;text-shadow: 1px 1px #aaa;color:#ffc552">' . date('H:i:s') . '</h5></div>';
      $data .= '<div class="col-sm-12 mt-4"><h5 style="font-size: 3vw;text-shadow: 1px 1px #aaa;color:#fff"><i class="far fa-power-off text-danger"></i> is Log-out</h5></div>';
      $data .= '</div></div>';
      echo $data;
      return false;
    }

    if (!$tamu) {
        $data = '<section class="wrapping__welcome" style="background: url('.base_url('assets/img/event/'.$event['poto']).'); background-repeat: no-repeat; background-size: cover;">';
        $data .= '<div class="wrapp__logo"><img src="'.base_url('assets/img/logo.png').'" alt=""></div>';
        $data .= '<div class="wrapp_text_content">';
        $data .= '</div>';
      echo $data;
    } else {
        $data = '<section class="wrapping__welcome" style="background: url('.base_url('assets/img/event/' . $wel['bg']) . ');  background-repeat: no-repeat; background-size: cover;">';
        $data .= '<div class="wrapp__logo"><img src="'.base_url('assets/img/logo.png').'" alt=""></div>';
        $data .= '<div class="wrapp_text_content">';
        $data .= '<span class="text__x letter__x" style="color:'.$wel['color'].'">'.$wel['welcome'].'</span>';
        $data .= '<h1 class="text__xl" style="color:'.$wel['color'].'">' . $tamu['nama'] . '</h1>';
        $data .= '<span class="text__x letter__s" style="color:'.$wel['color'].'">' . $tamu['alamat'] . '</span>';
        $data .= '</div>';
        if($tamu['vip'] == 1) {
            $data .='<div class="wrapp_vip"><svg xmlns="http://www.w3.org/2000/svg" width="1920" height="158" viewBox="0 0 1920 158" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M1920 0H0V158H1920V0ZM981.705 96.8184L970.455 61.4546H959.523L975.592 108H988.273L1004.32 61.4546H993.408L982.137 96.8184H981.705ZM1026.16 108V61.4546H1016.32V108H1026.16ZM1040.66 61.4546V108H1050.5V92.9092H1058.77C1062.35 92.9092 1065.39 92.25 1067.91 90.9316C1068.43 90.6602 1068.93 90.3662 1069.4 90.0503C1070.56 89.2661 1071.57 88.3457 1072.43 87.2891C1072.63 87.0415 1072.82 86.7866 1073 86.5244C1073.25 86.1665 1073.49 85.7949 1073.7 85.4092C1075.04 83.0454 1075.7 80.3184 1075.7 77.2271C1075.7 74.1362 1075.04 71.4092 1073.73 69.0454C1073.06 67.8315 1072.24 66.7539 1071.27 65.812C1070.34 64.9082 1069.26 64.1299 1068.04 63.4771C1065.56 62.1289 1062.55 61.4546 1059.02 61.4546H1040.66ZM1050.5 85.0229H1057.18C1057.48 85.0229 1057.77 85.0151 1058.05 84.999C1058.51 84.9727 1058.94 84.9248 1059.36 84.856C1059.84 84.7759 1060.29 84.667 1060.71 84.5298C1061.12 84.396 1061.51 84.2344 1061.86 84.0454C1062.03 83.9556 1062.19 83.8613 1062.35 83.7627C1062.48 83.6787 1062.61 83.5913 1062.73 83.501C1063.55 82.9067 1064.18 82.1714 1064.63 81.2954C1064.74 81.0928 1064.84 80.8848 1064.93 80.6714C1065.04 80.4019 1065.14 80.124 1065.22 79.8379C1065.45 79.0327 1065.57 78.1626 1065.57 77.2271C1065.57 76.5366 1065.5 75.8853 1065.38 75.2734C1065.23 74.5161 1064.98 73.8188 1064.63 73.1816C1064.03 72.0151 1063.11 71.1138 1061.86 70.4771C1060.62 69.8257 1059.04 69.5 1057.13 69.5H1050.5V85.0229ZM848 96H918V103.6C918 106.03 916.029 108 913.6 108H852.5C850.016 108 848 105.985 848 103.5V96ZM848.496 58.542C846.34 57.1519 843.547 58.9351 843.9 61.4766L847.641 88.4126C847.846 89.896 849.115 91 850.611 91H915.424C916.207 91 916.928 90.6982 917.467 90.1978C917.947 89.7505 918.283 89.1445 918.389 88.4531L922.508 61.4946C922.896 58.9531 920.117 57.1328 917.941 58.5039L902.848 68.0195C901.523 68.855 899.777 68.5303 898.842 67.2734L885.406 49.231C884.207 47.6201 881.793 47.6201 880.594 49.231L867.174 67.2515C866.232 68.5171 864.471 68.8359 863.143 67.9814L848.496 58.542Z" fill="black"/></svg></div>';
        } else {
            $data .='<div class="wrapp_vip"></div>';
        }
        $data .= '</section>';
        echo $data;
    }
}

public function autoLoadPage2()
{
$time = time();
$event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
$wel = $this->db->get_where('welcome', ['event_id' => $event['id']])->row_array();
$this->db->set('sapa', 0)->where(['event_id' => $event['id'], 'timer <'=> $time])->update('tamu');
    $tamu = $this->db->get_where('tamu', ['event_id' => $event['id'], 'sapa' => 1])->row_array();

    if (!$this->session->userdata('loginAksesNewImam')) {
    $data = '<div style="width: 100vw;height: 100vh; background-color: #000;padding-top:25vh;text-align:center"
        id="bgImg">';
        $data .= '<div class="row">';
            $data .= '<div class="col-sm-12">
                <h5 style="font-size: 7vw;text-shadow: 1px 1px #aaa;color:#ffc552">' . date('H:i:s') . '</h5>
            </div>';
            $data .= '<div class="col-sm-12 mt-4">
                <h5 style="font-size: 3vw;text-shadow: 1px 1px #aaa;color:#fff"><i
                        class="far fa-power-off text-danger"></i> is Log-out</h5>
            </div>';
            $data .= '</div>
    </div>';
    echo $data;
    return false;
    }

    if (!$tamu) {
    $data = '<div
        style="width: 100vw;height: 100vh; background: url(' . base_url('assets/img/event/' . $event['poto']) . '); background-size: cover;background-position: center;padding-top:25vh;text-align:center"
        id="bgImg"></div>';
    echo $data;
    } else {
    $data = '<div
        style="width: 100vw;height: 100vh; background: url(' . base_url('assets/img/event/' . $wel['bg']) . '); background-size: cover;background-position: center;padding-top:25vh;color:' . $wel['color'] . '"
        id="bgImg">';
        $data .= '<div class="row">';
            $data .= '<div class="col-sm-12">
                <h5 style="font-size: 2.8vw;text-shadow: 1px 1px #aaa;color:' . $wel['color'] . '">' . $wel['welcome'] .
                    '</h5>
            </div>';
            $data .= '<div class="col-sm-12 mt-4">
                <h5 style="font-size: 6.5vw;text-shadow: 1px 1px #aaa;color:' . $wel['color'] . '">' . $tamu['nama'] . '
                </h5>
            </div>';
            if ($tamu['vip'] == '1') {
            $data .= '<div class="col-sm-12 mt-3">
                <h6 class="rounded-pill d-inline-block"
                    style="font-size: 1.2vw;border: 1px 1px #aaa;padding: 8px 25px;background-color:#FECC15;color: #000">
                    <b>VIP</h6>
            </div>';
            $data .= '<div class="col-sm-12 mt-4">
                <h6 style="font-size: 1.8vw;text-shadow: 1px 1px #aaa;color:' . $wel['color'] . '">' . $tamu['alamat'] .
                    '</h6>';
                } else {
                $data .= '<div class="col-sm-12 mt-4">
                    <h6 style="font-size: 1.8vw;text-shadow: 1px 1px #aaa;color:' . $wel['color'] . '">' .
                        $tamu['alamat'] . '</h6>';
                    }
                    $data .= '<h6 style="font-size: 1vw;text-shadow: 1px 1px #aaa;color:' . $wel['color'] . '">' .
                        date('d/m/Y H:i:s', $tamu['jam_hadir']) . '</h6>';
                    $data .= '
                </div>
            </div>
        </div>';
        echo $data;
        }
        }

        public function autoLoadPageView()
        {
        $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
        $wel = $this->db->get_where('welcome', ['event_id' => $event['id']])->row_array();

        if (!$this->session->userdata('loginAksesNewImam')) {
        $data = '<div style="width: 100vw;height: 100vh; background-color: #000;padding-top:25vh;text-align:center"
            id="bgImg">';
            $data .= '<div class="row">';
                $data .= '<div class="col-sm-12">
                    <h5 style="font-size: 7vw;text-shadow: 1px 1px #aaa;color:#ffc552">' . date('H:i:s') . '</h5>
                </div>';
                $data .= '<div class="col-sm-12 mt-4">
                    <h5 style="font-size: 3vw;text-shadow: 1px 1px #aaa;color:#fff"><i
                            class="far fa-power-off text-danger"></i> is Log-out</h5>
                </div>';
                $data .= '</div>
        </div>';
        echo $data;
        return false;
        }

        $data = '<div
            style="width: 100vw;height: 100vh; background: url(' . base_url('assets/img/event/' . $wel['bg']) . '); background-size: cover;background-position: center;padding-top:25vh;text-align:center"
            id="bgImg">';
            $data .= '<div class="row">';
                $data .= '<div class="col-sm-12">
                    <h5 style="font-size: 4vw;text-shadow: 1px 1px #aaa;color:' . $wel['color'] . '">' . $wel['welcome']
                        . '</h5>
                </div>';
                $data .= '<div class="col-sm-12 mt-4">
                    <h5 style="font-size: 6.5vw;text-shadow: 1px 1px #aaa;color:' . $wel['color'] . '">IMAM dan PASANGAN
                    </h5>
                </div>';
                $data .= '<div class="col-sm-12 mt-3">
                    <h6 class="rounded-pill d-inline-block"
                        style="font-size: 1.2vw;border: 1px 1px #aaa;padding: 8px 25px;background-color:#FECC15;color: #000">
                        <b>VIP</h6>
                </div>';
                $data .= '<div class="col-sm-12 mt-4">
                    <h6 style="font-size: 3vw;text-shadow: 1px 1px #aaa;color:' . $wel['color'] . '">Kota Bekasi</h6>';
                    $data .= '<h6 style="font-size: 1.5vw;text-shadow: 1px 1px #aaa;color:#888">@info <i
                            class="fab fa-whatsapp"></i>08971851861</h6>';
                    $data .= '
                </div>
            </div>
        </div>';
        echo $data;
        }
        }
