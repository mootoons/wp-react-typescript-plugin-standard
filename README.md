# Wordpress React Plugin Standard

ปลั๊กอินเริ่มต้นสำหรับ React ซึ่งมี Packages WP-script, React, ReactRouter, Eslint, Prettier, i18n

สำหรับ javascript [WP React Plugin Standard](https://github.com/mootoons/wp-react-plugin-standard)

---

### Quick Start BY NPM

```sh
# Clone the Git repository
git clone https://github.com/mootoons/wp-react-typescript-plugin-standard.git

# Install node module packages
npm install

# Start development mode
npm start

# To run in production
npm run build

```

### Quick Start BY Yarn

```sh
# Clone the Git repository
git clone https://github.com/mootoons/wp-react-typescript-plugin-standard.git

# Install by yarn module packages
yarn

# Start development mode
yarn start

# To run in production
yarn build

```

---

### รายละเอียดการปรับแต่งสำหรับงานของคุณเอง

### Folder resources

- สามารถแก้ไข alias import ได้ที่ไฟล์ jsconfig.json และ webpack.config.js

### Folder app / search and replace

- my-app คือ text-domain และ filter key
- MyApp คือ namespace หรือ class name
- MY_APP\_ คือ constants ต่างๆ ที่ใช้ในปลั๊กอิน

หากแก้ไขในส่วนของ folder app เรียบร้อยแล้วให้รันคำสั่ง

```sh
composer install && composer dumpautoload -o
```

ในส่วนของ php จะใช้ Method onHooks ในการเรียกใช้งานอัตโนมัติ

### ตัวอย่างโค้ด

```php
class Example
{
    public function onHooks(): void
    {
        add_action('init', [$this, 'tester']);
    }

    public function tester(): void {
        var_dump('Hello Tester');
    }
}
```

### ตัวอย่าง

![MyApp-‹-Wordpress-Tester-—-WordPress](https://user-images.githubusercontent.com/11506169/179353573-4ed11b63-ae16-468b-b908-ed7ce67fee9c.jpg)

