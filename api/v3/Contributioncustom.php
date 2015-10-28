<?php

function civicrm_api3_contributioncustom_get($params) {
  $query = "SELECT contact_a.id as contact_id,
civicrm_pcp.id as pcp_id,
civicrm_event.id as event_id,
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
civicrm_contribution.check_number as contribution_check_number,
civicrm_value_donor_information_3.id as civicrm_value_donor_information_3_id, 
civicrm_value_donor_information_3.known_areas_of_interest_5 as custom_5, 
civicrm_value_donor_information_3.how_long_have_you_been_a_donor_6 as custom_6,
civicrm_value_draw_down_pledge.id as civicrm_value_draw_down_pledge_id,
civicrm_value_draw_down_pledge.pledge_id as custom_43 
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
LEFT JOIN civicrm_value_donor_information_3 ON civicrm_value_donor_information_3.entity_id = `civicrm_contribution`.id  
LEFT JOIN civicrm_value_draw_down_pledge ON civicrm_value_draw_down_pledge.entity_id = `civicrm_contribution`.id
LEFT JOIN civicrm_entity_financial_trxn ON (
        civicrm_entity_financial_trxn.entity_table = 'civicrm_contribution'
        AND civicrm_contribution.id = civicrm_entity_financial_trxn.entity_id ) LEFT JOIN civicrm_financial_trxn ON (
        civicrm_entity_financial_trxn.financial_trxn_id = civicrm_financial_trxn.id ) LEFT JOIN civicrm_entity_batch ON ( civicrm_entity_batch.entity_table = 'civicrm_financial_trxn'
        AND civicrm_financial_trxn.id = civicrm_entity_batch.entity_id ) LEFT JOIN civicrm_batch ON civicrm_entity_batch.batch_id = civicrm_batch.id LEFT JOIN civicrm_note ON ( civicrm_note.entity_table = 'civicrm_contribution' AND
                                                    civicrm_contribution.id = civicrm_note.entity_id ) 
LEFT JOIN civicrm_option_group option_group_payment_instrument ON ( option_group_payment_instrument.name = 'payment_instrument') 
LEFT JOIN civicrm_option_value contribution_payment_instrument ON (civicrm_contribution.payment_instrument_id = contribution_payment_instrument.value
                               AND option_group_payment_instrument.id = contribution_payment_instrument.option_group_id ) 
LEFT JOIN civicrm_option_group option_group_contribution_status ON (option_group_contribution_status.name = 'contribution_status') 
LEFT JOIN civicrm_option_value contribution_status ON (civicrm_contribution.contribution_status_id = contribution_status.value
                               AND option_group_contribution_status.id = contribution_status.option_group_id ) 
                               WHERE  ( civicrm_contribution.is_test = 0 )  AND (contact_a.is_deleted = 0)";
  
  $dao	       = CRM_Core_DAO::executeQuery($query);

  $contribution = array();
  while ($dao->fetch()) {
    $contribution[$dao->contribution_id] = $dao->toArray();
  }
  return civicrm_api3_create_success($contribution, $params, 'contributioncustom', 'get', $dao);
}

function _civicrm_api3_contributioncustom_get_spec(&$params) {
}