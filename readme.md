# 设置权限
# 1 sudo chmod -R 777 zan_back.marchsoft.cn

# 进入项目目录
# 2 cd　zan_back.marchsoft.cn

# 安装依赖
# 3 composer install

# 生成．.env
# 4 cp ./.env.example ./.env

# 生成key值
# 5 php artisan key:generate

# 在push到远程时,必须push到dev分支，不能动master
# 6 git push origin master:dev

# 6 每次推送到远程时先pull在push，有冲突及时解决！