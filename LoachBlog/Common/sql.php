<?php

//select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='category' order by a.article_created desc limit 0,10

select at.article_type_id as category_id,at.article_type_name as category_name from article_type as at where at.article_type_category='category' 