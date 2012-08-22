<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{title}</title>
</head>
<body>
<table style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953; width: 600px;">
  <tr>
    <td align="left"><a href="{store_url}" title="{store_name}"><img src="{logo}" alt="{store_name}" style="border: none;" ></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">{text_greeting}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="background-color: #c39; color:#FFF; font-size: 12px; font-weight: bold; padding: 0.5em 1em;">{text_order_detail}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">{text_order_id} <span style="color: #c39; font-weight: bold;">{order_id}</span><br />
      {text_date_added} {date_added}<br >
      {text_payment_method} <strong>{payment_method}</strong><br />
      {text_shipping_method} <strong>{shipping_method}</strong><br />
	  <br />
	  {text_email} <strong>{customer_email}</strong><br />
	  {text_phone} <strong>{customer_phone}</strong><br />
	  {text_ip} <strong>{ip}</strong>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table style="width: 100%; font-family: Verdana,sans-serif; font-size: 11px; color: #FFFFFF;">
        <tr style="background-color: #CCCCCC; text-transform: uppercase;">
          <th style="text-align: left; padding: 0.3em;">{text_shipping_address}</th>
          <th style="text-align: left; padding: 0.3em;">{text_payment_address}</th>
        </tr>
        <tr>
          <td style="padding: 0.3em; background-color: #EEEEEE; color: #000;">
          	{shipment_address}
          		{firstname} {lastname}<br />
          		{address}<br />
          		{city} {zipcode}<br />
          		{state}<br />
          		{country}
          	{/shipment_address}
          </td>
          <td style="padding: 0.3em; background-color: #EEEEEE; color: #000;">
          	{payment_address}
          		{nif}<br />
          		{firstname} {lastname}<br />
          		{address}<br />
          		{city} {zipcode}<br />
          		{state}<br />
          		{country}
          	{/payment_address}
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><table style="width: 100%; font-family: Verdana,sans-serif; font-size: 11px; color: #000000;">
        <tr style="background-color: #CCCCCC;">
          <th align="left" style="padding: 0.3em; color: #FFFFFF;">{column_product}</th>
          <th align="left" style="width: 15%; padding: 0.3em; color: #FFFFFF;">{column_model}</th>
          <th align="right" style="width: 15%; padding: 0.3em; color: #FFFFFF;">{column_price}</th>
          <th align="right" style="width: 15%; padding: 0.3em; color: #FFFFFF;">{column_quantity}</th>
          <th align="right" style="width: 20%; padding: 0.3em; color: #FFFFFF;">{column_total}</th>
        </tr>
        {order_products}
        <tr style="background-color: #EEEEEE; text-align: center;">
          <td align="left">{name}</td>
          <td align="left">{model}</td>
          <td align="right">{price}</td>
          <td align="right">{quantity}</td>
          <td align="right">{total}</td>
        </tr>
        {/order_products}
        {order_totals}
        <tr style="text-align: right;">
          <td colspan="3">&nbsp;</td>
          <td style="background-color: #EEEEEE; font-weight: bold; padding: 0.3em;">{total_title}</td>
          <td style="background-color: #EEEEEE; padding: 0.3em;">{total_text}</td>
        </tr>
        {/order_totals}
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="background-color: #c39; color: #FFF; font-size: 12px; font-weight: bold; padding: 0.5em 1em;">{text_comment}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">{comment}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size: 10px; border-top: 1px solid #c39;"><a href="{store_url}" style="color: #c39; font-weight: bold; text-decoration: none;">{store_name}</a> - <a href="http://www.masportales.es" style="text-decoration: none; color: #374953;">{text_powered_by}</a></td>
  </tr>
</table>
</body>
</html>
