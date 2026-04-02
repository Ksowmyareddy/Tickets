

<?php
class Search_model extends CI_Model {

public function search_products($keyword,$limit,$offset)
{

$this->db->distinct();

$this->db->select("
p.product_id,
IFNULL(vp.product_code,'') as product_code,
pd.product,
GROUP_CONCAT(DISTINCT cd.category SEPARATOR ', ') as category
");

$this->db->from('cscart_products p');

$this->db->join('cscart_product_descriptions pd','pd.product_id=p.product_id','left');

$this->db->join('cscart_az_vendor_product vp','vp.product_id=p.product_id','left');

$this->db->join('cscart_products_categories pc','pc.product_id=p.product_id','left');

$this->db->join('cscart_category_descriptions cd','cd.category_id=pc.category_id','left');

$this->db->join('cscart_az_m_productsbyvehicle pv','pv.product_id=p.product_id','left');

$this->db->join('cscart_az_m_OEM o','o.OEM_id=pv.OEM_id','left');

$this->db->join('cscart_az_m_model m','m.model_id=pv.model_id','left');

$this->db->join('cscart_az_m_variant v','v.variant_id=pv.variant_id','left');

/* CORRECT SEARCH LOGIC */

$this->db->group_start();

/* MAIN SEARCH */
$this->db->like('pd.product',$keyword);

/* Optional searches */
$this->db->or_like('vp.product_code',$keyword);
$this->db->or_like('o.OEM_name',$keyword);
$this->db->or_like('m.model_name',$keyword);
$this->db->or_like('v.variant_name',$keyword);

$this->db->group_end();

$this->db->group_by('p.product_id');

$this->db->limit($limit,$offset);

return $this->db->get()->result();

}


public function get_fitment($product_id)
{

$this->db->select("
o.OEM_name AS brand_name,
m.model_name AS model_name,
v.variant_name AS variant_name,
pv.production_year AS st_year
");

$this->db->from('cscart_az_m_productsbyvehicle pv');

$this->db->join('cscart_az_m_OEM o','o.OEM_id=pv.OEM_id','left');

$this->db->join('cscart_az_m_model m','m.model_id=pv.model_id','left');

$this->db->join('cscart_az_m_variant v','v.variant_id=pv.variant_id','left');

$this->db->where('pv.product_id',$product_id);

return $this->db->get()->result();

}

}