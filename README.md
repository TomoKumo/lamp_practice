# lamp_practice  

## ローカルでの起動方法

### 1.Docker Desktopを起動する  

### 2.適当なディレクトリを用意して、``git clone https://github.com/TomoKumo/lamp_practice``

### 3.cloneが完了したら、compose.yamlと同階層に。.envを用意して下記の内容を貼り付ける
***
MYSQL_ROOT_PASSWORD=root  
MYSQL_DATABASE=test_db  
MYSQL_USER=test_user  
MYSQL_PASSWORD=test_password  

PMA_USER=test_user  
PMA_PASSWORD=test_password  

WEB_PORT=8080  
MYSQL_PORT=3306  
PMA_PORT=8081  
***

### 4.compose.yamlのある階層で``docker-compose up``

### 5.ローカルでページが閲覧できます  
  http://localhost:8080/  
　→Webページの閲覧  
　http://localhost:8081/   
　→phpMyAdminの閲覧  