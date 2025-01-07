CREATE OR REPLACE view items_view as
SELECT items.*  , categories.* FROM items 
INNER JOIN categories ON categories.categories_id = items.items_cat 

CREATE OR REPLACE view myfavourite as
SELECT favourite.* , items.* , users.users_id FROM favourite
INNER join users ON favourite.favourite_usersid = users.users_id
INNER join items ON favourite.favourite_itemsid = items.items_id


CREATE OR REPLACE view cartview as
SELECT SUM(items.items_price - items.items_price * items.items_discount / 100) as itemsprice , COUNT(cart.cart_itemsid) as countitems , cart.* , items.* FROM cart
INNER join items ON items.items_id = cart.cart_itemsid
WHERE cart_orders = 0
GROUP BY cart.cart_itemsid , cart.cart_usersid