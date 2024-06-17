<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_table extends CI_Model
{

  public function creatUser()
  {
    $cek = $this->db->get('user')->num_rows();
    $pass_admin = passHash('Admin2024');
    $pass_demo = passHash('demo123');
    if ($cek <= 0) {
      $data_admin = [
        'id' => 1,
        'nama' => 'My Admin',
        'username' => 'admin',
        'password' => $pass_admin,
        'email' => 'admin@gmail.com',
        'role' => 1,
        'active' => 1,
        'event_id' => 0,
        'tgl' => date('Y-m-d'),
        'kode' => '000',
        'leader_id' => '0',
        'kuota_wa' => '0'
      ];
      $data_demo = [
        'id' => 2,
        'nama' => 'Demo Akun',
        'username' => 'demo',
        'password' => $pass_demo,
        'email' => 'demo@gmail.com',
        'role' => 3,
        'active' => 1,
        'event_id' => 1,
        'tgl' => date('Y-m-d'),
        'kode' => '000',
        'leader_id' => '0',
        'kuota_wa' => '100'
      ];
      $this->db->insert('user', $data_admin);
      $this->db->insert('user', $data_demo);
    }
  }



  public function creatEvent()
  {
    $cek = $this->db->get('event')->num_rows();
    $kode = generate_random_string(8);
    if ($cek <= 0) {
      $data = [
        'nama' => 'Putra & Putri',
        'wedding' => 'THE WEDDING OFF',
        'tgl' => '2023-12-12',
        'kode' => $kode,
        'undangan' => 'https://weddingkamiberdua.com/test-undangan/',
        'poto' => 'baner.jpg',
        'leader_id' => 0,
        'wa' => 'xxxxx',
        'undangan_id' => 1,
        'id_post' => '8406'
      ];

      $this->db->insert('event', $data);
    }
  }


  public function creatUndangan()
  {
    $cek = $this->db->get('undangan')->num_rows();
    if ($cek <= 0) {
      $data = [
        'id' => 1,
        'url' => 'https://weddingkamiberdua.com/'
      ];

      $this->db->insert('undangan', $data);
    }
  }

  public function creatGroup()
  {
    $cek = $this->db->get('group_tamu')->num_rows();
    if ($cek <= 0) {
      $data = [
        'id' => 1,
        'nama' => 'Tamu Umum'
      ];

      $this->db->insert('group_tamu', $data);
    }
  }




  public function creatTbUser()
  {
    $this->load->dbforge();

    $field = [
      'id' => [
        'type' => 'int',
        'constraint' => 30,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'nama' => [
        'type' => 'varchar',
        'constraint' => 50
      ],
      'username' => [
        'type' => 'varchar',
        'constraint' => 100
      ],
      'password' => [
        'type' => 'varchar',
        'constraint' => 300
      ],
      'email' => [
        'type' => 'varchar',
        'constraint' => 100
      ],
      'role' => [
        'type' => 'int',
        'constraint' => 1
      ],
      'active' => [
        'type' => 'int',
        'constraint' => 1
      ],
      'event_id' => [
        'type' => 'bigint',
        'constraint' => 30
      ],
      'tgl' => [
        'type' => 'date'
      ],
      'kode' => [
        'type' => 'varchar',
        'constraint' => 10,
        'default' => '000'
      ],
      'leader_id' => [
        'type' => 'bigint',
        'constraint' => 30,
        'default' => 0
      ],
      'jml_event' => [
        'type' => 'int',
        'constraint' => 5,
        'default' => 1
      ],
      'undangan_id' => [
        'type' => 'int',
        'constraint' => 20,
        'default' => 1
      ],
      'kuota_wa' => [
        'type' => 'int',
        'constraint' => 50,
        'default' => 1
      ],
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('user', true);
  }

  public function creatTbEvent()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'int',
        'constraint' => 30,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'nama' => [
        'type' => 'varchar',
        'constraint' => 100
      ],
      'wedding' => [
        'type' => 'varchar',
        'constraint' => 100,
        'default' => 'THE WEDDING OF'
      ],
      'tgl' => [
        'type' => 'date'
      ],
      'kode' => [
        'type' => 'varchar',
        'constraint' => 10
      ],
      'undangan' => [
        'type' => 'varchar',
        'constraint' => 300
      ],
      'poto' => [
        'type' => 'varchar',
        'constraint' => 300
      ],
      'leader_id' => [
        'type' => 'bigint',
        'constraint' => 30,
        'default' => 1
      ],
      'wa' => [
        'type' => 'longtext'
      ],
      'undangan_id' => [
        'type' => 'bigint',
        'constraint' => 30
      ],
      'id_post' => [
        'type' => 'varchar',
        'constraint' => 30
      ],
      'is_qr' => [
        'type' => 'int',
        'constraint' => 1,
        'default' => 1
      ],
      'fitur_meja' => [
        'type' => 'int',
        'constraint' => 1,
        'default' => 1
      ],
      'fitur_ampao' => [
        'type' => 'int',
        'constraint' => 1,
        'default' => 1
      ],
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('event', true);
  }

  public function creatKey()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'int',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'user_id' => [
        'type' => 'int',
        'constraint' => 20
      ],
      'key' => [
        'type' => 'varchar',
        'constraint' => 45
      ],
      'level' => [
        'type' => 'int',
        'constraint' => 2
      ],
      'ignore_limits' => [
        'type' => 'int',
        'constraint' => 1
      ],
      'is_private_key' => [
        'type' => 'int',
        'constraint' => 1
      ],
      'ip_addresses' => [
        'type' => 'text'
      ],
      'date_created' => [
        'type' => 'int',
        'constraint' => 12
      ],
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('keys_api', true);
  }

  public function creatKode()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'bigint',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'kode' => [
        'type' => 'varchar',
        'constraint' => 15
      ],
      'active' => [
        'type' => 'int',
        'constraint' => 1
      ],
      'tgl' => [
        'type' => 'date'
      ],
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('kode', true);
  }


  public function creatTbtamu()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'bigint',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'event_id' => [
        'type' => 'bigint',
        'constraint' => 30
      ],
      'nama' => [
        'type' => 'varchar',
        'constraint' => 100
      ],
      'alamat' => [
        'type' => 'varchar',
        'constraint' => 100,
        'default' => '-'
      ],
      'vip' => [
        'type' => 'varchar',
        'constraint' => 10,
        'default' => '-'
      ],
      'jam_hadir' => [
        'type' => 'int',
        'constraint' => 15,
        'default' => 0
      ],
      'jml_tamu' => [
        'type' => 'int',
        'constraint' => 10,
        'default' => 0
      ],
      'timer' => [
        'type' => 'int',
        'constraint' => 15,
        'default' => 0
      ],
      'sapa' => [
        'type' => 'int',
        'constraint' => 1,
        'default' => 0
      ],
      'qr' => [
        'type' => 'varchar',
        'constraint' => 100,
        'default' => '-'
      ],
      'group_id' => [
        'type' => 'int',
        'constraint' => 5,
        'default' => 1
      ],
      'souvenir' => [
        'type' => 'int',
        'constraint' => 5,
        'default' => 0
      ],
      'nomor_wa' => [
        'type' => 'varchar',
        'constraint' => 50,
        'default' => null
      ],
      'nomor_meja' => [
        'type' => 'varchar',
        'constraint' => 50,
        'default' => null
      ],
      'nomor_ampao' => [
        'type' => 'varchar',
        'constraint' => 50,
        'default' => null
      ],
      'is_sent' => [
        'type' => 'int',
        'constraint' => 50,
        'default' => 0
      ],
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('tamu', true);
  }


  public function creatTbTamuImport()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'bigint',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'event_id' => [
        'type' => 'bigint',
        'constraint' => 30
      ],
      'nama' => [
        'type' => 'varchar',
        'constraint' => 100
      ],
      'alamat' => [
        'type' => 'varchar',
        'constraint' => 100,
        'default' => '-'
      ],
      'vip' => [
        'type' => 'varchar',
        'constraint' => 100,
        'default' => '-'
      ],
      'group_id' => [
        'type' => 'int',
        'constraint' => 5,
        'default' => 1
      ],
      'nomor_wa' => [
        'type' => 'varchar',
        'constraint' => 50,
        'default' => null
      ],
      'nomor_meja' => [
        'type' => 'varchar',
        'constraint' => 50,
        'default' => null
      ],
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('tamu_import', true);
  }

  public function creatTbUndangan()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'bigint',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'url' => [
        'type' => 'varchar',
        'constraint' => 200,
        'default' => 'https://weddingkamiberdua.com/'
      ],
      'token' => [
        'type' => 'varchar',
        'constraint' => 200,
        'default' => 'xxxx'
      ]
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('undangan', true);
  }

  public function creatTbWelcome()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'bigint',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'event_id' => [
        'type' => 'bigint',
        'constraint' => 30
      ],
      'kode' => [
        'type' => 'varchar',
        'constraint' => 30,
        'default' => 0
      ],
      'bg' => [
        'type' => 'varchar',
        'constraint' => 300
      ],
      'color' => [
        'type' => 'varchar',
        'constraint' => 100
      ],
      'welcome' => [
        'type' => 'varchar',
        'constraint' => 100,
        'default' => 'Selamat Datang'
      ]
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('welcome', true);
  }



  public function creatTbGroupTamu()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'bigint',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'nama' => [
        'type' => 'varchar',
        'constraint' => 200,
        'default' => 'Tamu Umum'
      ],
      'deskripsi' => [
        'type' => 'varchar',
        'constraint' => 200,
      ],
      'user_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'event_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'kode' => [
        'type' => 'int',
        'constraint' => 20,
      ],
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('group_tamu', true);
  }

  public function creatTbBlastHistory()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'int',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'tamu_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'event_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'user_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'campaign_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'device' => [
        'type' => 'varchar',
        'constraint' => 50,
      ],
      'nama_tamu' => [
        'type' => 'varchar',
        'constraint' => 100,
      ],
      'nomor_wa' => [
        'type' => 'varchar',
        'constraint' => 50,
      ],
      'status' => [
        'type' => 'tinyint',
        'constraint' => 1,
      ],
      'response' => [
        'type' => 'text',
      ],
      'created_at' => [
        'type' => 'datetime',
      ]
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('blast_history', true);
  }

  public function creatTbCampaign()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'int',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'user_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'event_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'leader_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'name' => [
        'type' => 'varchar',
        'constraint' => 50,
      ],
      'template' => [
        'type' => 'text',
      ],
      'delay' => [
        'type' => 'int',
        'constraint' => 50,
      ],
      'status' => [
        'type' => 'enum',
        'constraint' => array('waiting', 'starting', 'running', 'finished'),
      ],
      'sender' => [
        'type' => 'varchar',
        'constraint' => 50
      ],
      'campaign_type' => [
        'type' => 'enum',
        'constraint' => array('group', 'selected'),
      ],
      'receivers' => [
        'type' => 'text',
      ],
      'schedule' => [
        'type' => 'datetime',
      ],
      'created_at' => [
        'type' => 'timestamp',
      ],
      'updated_at' => [
        'type' => 'timestamp',
      ]
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('campaigns', true);
  }

  public function creatTbKuotaWa()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'int',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'user_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'kuota' => [
        'type' => 'int',
      ]
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('kuota_wa', true);
  }
  
  public function creatTbWaDevices()
  {
    $this->load->dbforge();
    $field = [
      'id' => [
        'type' => 'int',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'user_id' => [
        'type' => 'int',
        'constraint' => 20,
      ],
      'nomor_wa' => [
        'type' => 'bigint',
      ],
      'status' => [
        'type' => 'varchar',
        'constraint' => 50,
      ]
    ];
    $this->dbforge->add_field($field);
    $this->dbforge->add_key('id', true);
    return $this->dbforge->create_table('wa_devices', true);
  }
}