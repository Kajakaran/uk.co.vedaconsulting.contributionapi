<?php

function civicrm_api3_contributioncustom_get($params) {
  $select = "SELECT contact_a.id as contact_id,
civicrm_pcp.id as pcp_id,
civicrm_pcp.status_id as pcp_status_id,
civicrm_pcp.title as pcp_title,
civicrm_pcp.intro_text as pcp_intro_text,
civicrm_pcp.page_text as pcp_page_text,
civicrm_pcp.donate_link_text as pcp_donate_link_text,
civicrm_pcp.page_id as pcp_page_id,
civicrm_pcp.page_type as pcp_page_type,
civicrm_pcp.pcp_block_id as pcp_block_id,
civicrm_pcp.is_thermometer as pcp_is_thermometer,
civicrm_pcp.is_honor_roll as pcp_is_honor_roll,
civicrm_pcp.goal_amount as pcp_goal_amount,
civicrm_pcp.currency as pcp_currency,
civicrm_pcp.is_active as pcp_is_active,
civicrm_pcp.is_notify as pcp_is_notify,
civicrm_event.id as event_id,
civicrm_event.title as event_title,
civicrm_event.summary as event_summary,
civicrm_event.description as event_description,
civicrm_event.event_type_id as event_type_id,
civicrm_event.participant_listing_id as event_participant_listing_id,
civicrm_event.is_public as is_public,
civicrm_event.start_date as event_start_date,
civicrm_event.end_date as event_end_date,
civicrm_event.is_online_registration as event_is_online_registration,
civicrm_event.registration_start_date as event_registration_start_date,
civicrm_event.registration_end_date as event_registration_end_date,
civicrm_event.max_participants as event_max_participants,
civicrm_event.financial_type_id as event_financial_type_id,
civicrm_event.payment_processor as event_payment_processor,
civicrm_event.is_active as event_is_active,
contact_a.contact_type  as `contact_type`, 
contact_a.contact_sub_type  as `contact_sub_type`,
contact_a.sort_name  as `sort_name`,
contact_a.display_name  as `display_name`, 
civicrm_contribution.id as contribution_id, 
civicrm_contribution.currency as `currency`, 
civicrm_contribution.receive_date as `receive_date`, 
civicrm_contribution.non_deductible_amount as `non_deductible_amount`,
civicrm_contribution.total_amount as `total_amount`,
civicrm_contribution.fee_amount as `fee_amount`,
civicrm_contribution.net_amount as `net_amount`,
civicrm_contribution.trxn_id as `trxn_id`,
civicrm_contribution.invoice_id as `invoice_id`,
civicrm_contribution.cancel_date as `cancel_date`, 
civicrm_contribution.cancel_reason as `cancel_reason`, 
civicrm_contribution.receipt_date as `receipt_date`,
civicrm_contribution.thankyou_date as `thankyou_date`,
civicrm_contribution.source as contribution_source,
civicrm_contribution.amount_level as `amount_level`,
civicrm_contribution.is_test as `is_test`,
civicrm_contribution.is_pay_later as `is_pay_later`,
contribution_status.value as contribution_status_id,
civicrm_contribution.check_number as `check_number`, 
civicrm_contribution.campaign_id as contribution_campaign_id, 
civicrm_financial_type.id as financial_type_id,
civicrm_financial_type.name as financial_type, 
civicrm_product.id as product_id,
civicrm_product.name as `product_name`,
civicrm_product.sku as `sku`,
civicrm_contribution_product.id as contribution_product_id,
civicrm_contribution_product.product_option as `product_option`, 
civicrm_contribution_product.fulfilled_date as `fulfilled_date`,
civicrm_contribution_product.start_date as `contribution_start_date`, 
civicrm_contribution_product.end_date as `contribution_end_date`, 
civicrm_contribution.contribution_recur_id as `contribution_recur_id`, 
civicrm_financial_account.id as financial_account_id, 
civicrm_financial_account.accounting_code as accounting_code, 
civicrm_note.note as contribution_note, 
civicrm_batch.title as contribution_batch, 
contribution_status.label as contribution_status, 
contribution_payment_instrument.label as payment_instrument, 
contribution_payment_instrument.value as instrument_id, 
contribution_payment_instrument.value as payment_instrument_id, 
civicrm_contribution.check_number as contribution_check_number
FROM civicrm_contact contact_a 
LEFT JOIN civicrm_contribution ON civicrm_contribution.contact_id = contact_a.id
LEFT JOIN civicrm_contribution_soft ON civicrm_contribution_soft.contribution_id = civicrm_contribution.id
LEFT JOIN civicrm_pcp ON civicrm_pcp.id = civicrm_contribution_soft.pcp_id
LEFT JOIN civicrm_participant_payment ON civicrm_participant_payment.contribution_id = civicrm_contribution.id
LEFT JOIN civicrm_participant ON civicrm_participant.id = civicrm_participant_payment.participant_id
LEFT JOIN civicrm_event ON civicrm_event.id = civicrm_participant.event_id
INNER JOIN civicrm_financial_type ON civicrm_contribution.financial_type_id = civicrm_financial_type.id 
LEFT JOIN civicrm_entity_financial_account ON civicrm_entity_financial_account.entity_id = civicrm_contribution.financial_type_id AND civicrm_entity_financial_account.entity_table = 'civicrm_financial_type'  
INNER JOIN civicrm_financial_account ON civicrm_financial_account.id = civicrm_entity_financial_account.financial_account_id 
INNER JOIN civicrm_option_value cov ON cov.value = civicrm_entity_financial_account.account_relationship AND cov.name = 'Income Account is'  
INNER JOIN civicrm_option_group cog ON cog.id = cov.option_group_id AND cog.name = 'account_relationship' 
LEFT  JOIN civicrm_contribution_product ON civicrm_contribution_product.contribution_id = civicrm_contribution.id 
LEFT  JOIN civicrm_product ON civicrm_contribution_product.product_id =civicrm_product.id  
LEFT JOIN civicrm_entity_financial_trxn ON (
        civicrm_entity_financial_trxn.entity_table = 'civicrm_contribution'
        AND civicrm_contribution.id = civicrm_entity_financial_trxn.entity_id )
LEFT JOIN civicrm_financial_trxn ON (
        civicrm_entity_financial_trxn.financial_trxn_id = civicrm_financial_trxn.id )
LEFT JOIN civicrm_entity_batch ON ( civicrm_entity_batch.entity_table = 'civicrm_financial_trxn'
        AND civicrm_financial_trxn.id = civicrm_entity_batch.entity_id )
LEFT JOIN civicrm_batch ON civicrm_entity_batch.batch_id = civicrm_batch.id
LEFT JOIN civicrm_note ON ( civicrm_note.entity_table = 'civicrm_contribution' AND
                                                    civicrm_contribution.id = civicrm_note.entity_id ) 
LEFT JOIN civicrm_option_group option_group_payment_instrument ON ( option_group_payment_instrument.name = 'payment_instrument') 
LEFT JOIN civicrm_option_value contribution_payment_instrument ON (civicrm_contribution.payment_instrument_id = contribution_payment_instrument.value
                               AND option_group_payment_instrument.id = contribution_payment_instrument.option_group_id ) 
LEFT JOIN civicrm_option_group option_group_contribution_status ON (option_group_contribution_status.name = 'contribution_status') 
LEFT JOIN civicrm_option_value contribution_status ON (civicrm_contribution.contribution_status_id = contribution_status.value
                               AND option_group_contribution_status.id = contribution_status.option_group_id )";
  
  $where = " WHERE (contact_a.is_deleted = 0) ";
  $whereClause = array();
  
  if (isset($params['pcp_id']) && !empty($params['pcp_id'])) {
    $whereClause [] = "civicrm_pcp.id = {$params['pcp_id']}";    
  }
  
  if (isset($params['event_id']) && !empty($params['event_id'])) {
    $whereClause [] = "civicrm_event.id = {$params['event_id']}";    
  }
  if (isset($params['total_amount']) && !empty($params['total_amount'])) {
    $whereClause [] = "civicrm_contribution.total_amount = {$params['total_amount']}";
  }
  if (isset($params['contribution_page_id']) && !empty($params['contribution_page_id'])) {
    $whereClause [] = "civicrm_contribution.contribution_page_id = {$params['contribution_page_id']}";
  }
  if (isset($params['financial_type_id']) && !empty($params['financial_type_id'])) {
    $whereClause [] = "civicrm_contribution.financial_type_id = {$params['financial_type_id']}";
  }
  if (isset($params['payment_instrument_id']) && !empty($params['payment_instrument_id'])) {
    $whereClause [] = "civicrm_contribution.payment_instrument_id = {$params['payment_instrument_id']}";    
  }
  if (isset($params['source']) && !empty($params['source'])) {
    $whereClause [] = "civicrm_contribution.source = '{$params['source']}'";    
  } 
  if (isset($params['is_test']) && !empty($params['is_test'])) {
    $whereClause [] = "civicrm_contribution.is_test = {$params['is_test']}";    
  }
  if (isset($params['net_amount']) && !empty($params['net_amount'])) {
    $whereClause [] = "civicrm_contribution.net_amount = {$params['net_amount']}";    
  }
  if (isset($params['campaign_id']) && !empty($params['campaign_id'])) {
    $whereClause [] = "civicrm_contribution.campaign_id = {$params['campaign_id']}";    
  }
  if (isset($params['is_pay_later']) && !empty($params['is_pay_later'])) {
    $whereClause [] = "civicrm_contribution.is_pay_later = {$params['is_pay_later']}";    
  }
  if (isset($params['check_number']) && !empty($params['check_number'])) {
    $whereClause [] = "civicrm_contribution.check_number = '{$params['check_number']}'";    
  }
  if (isset($params['contribution_id']) && !empty($params['contribution_id'])) {
    $whereClause [] = "civicrm_contribution.id = {$params['contribution_id']}";    
  }
  
  if (!empty($params['receive_date_from'])) {
    $startReceiveDate = CRM_Utils_Date::processDate($params['receive_date_from']);
    $whereClause [] = " civicrm_contribution.receive_date >= '{$startReceiveDate}' ";
  }
  if (!empty($params['receive_date_to'])) {
      $endReceiveDate = CRM_Utils_Date::processDate($params['receive_date_to']);
      $whereClause [] = " civicrm_contribution.receive_date <= '{$endReceiveDate}' ";
  }
  if (!empty($whereClause)) {
    $where .= " AND ". implode(' AND ', $whereClause);
  }
  $sql	  = "$select $where";
  $sql	 .= " LIMIT 0, 25 "; 
                               
  $dao	       = CRM_Core_DAO::executeQuery($sql);

  $contribution = array();
  while ($dao->fetch()) {
    $contribution[$dao->contribution_id] = $dao->toArray();
  }
  return civicrm_api3_create_success($contribution, $params, 'contributioncustom', 'get', $dao);
}

function _civicrm_api3_contributioncustom_get_spec(&$params) {
  $params['pcp_id']['api.aliases'] = array('PCP ID');
  $params['event_id']['api.aliases'] = array('Event ID');
  $params['receive_date_from']['api.aliases'] = array('Receive Date From');
  $params['receive_date_to']['api.aliases'] = array('Receive Date To');
  $params['total_amount']['api.aliases'] = array('total_amount');
  $params['source']['api.aliases'] = array('source');
  $params['net_amount']['api.aliases'] = array('net_amount');
  $params['is_test']['api.aliases'] = array('is_test');
  $params['is_pay_later']['api.aliases'] = array('is_pay_later');
  $params['payment_instrument']['api.aliases'] = array('payment_instrument');
  $params['check_number']['api.aliases'] = array('check_number');
  $params['campaign_id']['api.aliases'] = array('campaign_id');
  $params['contribution_id']['api.aliases'] = array('Contribution_id');
  $params['financial_type_id']['api.aliases'] = array('financial_type_id');
  $params['contribution_page_id']['api.aliases'] = array('contribution_page_id');
}
