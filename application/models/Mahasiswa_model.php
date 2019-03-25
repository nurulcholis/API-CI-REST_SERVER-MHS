<?php

class Mahasiswa_model extends CI_Model
{

     function fetch_mahasiswa( $id = null )
     {
          if( $id == null ) {

               return $this->db->query("select * from mahasiswa")->result_array();

          } else {

               return $this->db->query("select * from mahasiswa where id = '$id' ")->result_array();

          }
          
     }

     function delete_mahasiswa( $id ) {

          $this->db->delete('mahasiswa',['id' => $id]);

          return $this->db->affected_rows();

     }

     function insert_mahasiswa($data)
     {

          $this->db->insert('mahasiswa',$data);

          return $this->db->affected_rows();

     }

     function update_mahasiswa($data, $id) 
     {

          $this->db->update('mahasiswa',$data,['id' => $id]);

          return $this->db->affected_rows();

     }

}