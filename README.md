# SimpleMVC

## Backend
**SimpleMVC** is a simple PHP MVC framework

### Requirements ：

* PHP 5.6.0+

### Directories

```
project                 Root
├─app                   Applications
│  ├─controllers        Controllers
│  ├─models             Models
│  ├─views              Views
├─config                Configurations
├─core                  Framework Core files
├─static                Resources files : CSS, JS, Images
├─index.php             
```

### How to use

#### 1. Clone

```
```

#### 2. Create Database 

#### 3. Modify configurations in config/config.php

```
$config['db']['host'] = 'localhost';
$config['db']['username'] = 'root';
$config['db']['password'] = '123456';
$config['db']['dbname'] = 'project';
```

#### 4. Test
`http://localhost/`

## Frontend - Build with Vue-cli, Vuejs, Vuex, Vue-router, Axios

# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
