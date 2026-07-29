<?php
return [
 'google_maps'=>['embed_key'=>env('GOOGLE_MAPS_EMBED_KEY'),'place_query'=>env('GOOGLE_MAPS_PLACE_QUERY','Valley Road, Canaansite Estate, Nakwero, Gayaza, Uganda')],
 'youtube'=>['api_key'=>env('YOUTUBE_API_KEY')],
 'brevo'=>['api_key'=>env('BREVO_API_KEY')],
 'africas_talking'=>['username'=>env('AFRICASTALKING_USERNAME'),'api_key'=>env('AFRICASTALKING_API_KEY')],
 'whatsapp'=>['token'=>env('WHATSAPP_CLOUD_TOKEN'),'phone_number_id'=>env('WHATSAPP_PHONE_NUMBER_ID')],
 'payments'=>['provider'=>env('PAYMENT_PROVIDER'),'public_key'=>env('PAYMENT_PUBLIC_KEY'),'secret_key'=>env('PAYMENT_SECRET_KEY')],
];
