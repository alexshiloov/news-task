# Тестовое задание

Используя PHP 7.3 и Symfony 4 сделать следующее:

#### Задача:
1. Разработать модель данных "Новости", содержащее следующие поля:
    
    | Поле | Описание |
    | ---- | ---- |
    | id | ID |
    | title | Заголовок новости |
    | slug | Ссылка на новость. Генерируется на основании title. Всегда уникален |
    | description | Описание |
    | shortDescription | краткое описание |
    | cratedAt | дата создания. Дата ставится автоматом при создании новости |
    | updatedAt | Дата обновления. Дата ставится при обновлении новости |
    | publishedAt | Дата публикации. Дата приходит извне |
    | isActive | Флаг активности новости |
    | isHide | Флаг скрытости новости |
    | hits | Количество просмотров новости |
    
2. Сделать миграцию.
3. Используя подход REST сделать 2 контроллера.
    1. Контроллер для админки CRUD. Все данные отправляются в формате JSON.
        1. Create
        2. Update
        3. Delete
    2. Контроллер для фронтовой части. 
`Update 30.06.2020 22:38. Отдавать данные надо в формате JSON`
        1. Получение списка новостей
            1. Фильтр isActive = true
            1. Фильтр isHide = false
            1. Фильтр publishedAt от сейчас и старше
            1. Сортировка по полю publishedAt от новых к старым.
            1. Количество новостей 20 штук на странице `Update 30.06.2020 22:38. Количество элементов на странице приходит с фронта`
            1. Текущая страница
        2. Получение новости по slug
            1. Фильтр isActive = true
            1. Фильтр isHide = false
            1. Фильтр publishedAt от сейчас и старше
4. Сделать автоматическое создание sitemap для новостей `Update 30.06.2020 22:38. Sitemap должен генерироваться автоматически при создании/изменинии/удалении новости`
    1. В sitemap попадают только новости со следующими фильтрами
        1. Фильтр isActive = true
        1. Фильтр isHide = false
        1. Фильтр publishedAt от сейчас и старше
        1. Сортировка по полю publishedAt от новых к старым. 

### Замечания:
1. При получении новости для фронтовой части, если новость стоит с параметром isActive = false отдаем 404 ошибку
1. Если новость имеет следующий параметр isActive = true и isHide = true должен быть доступен по прямой ссылке, но не должен попадать в список новостей и в sitemap
1. Если publishedAt больше чем сейчас должен отдавать 404 и не важно какие параметры установлены в isActive и isHide
1. Генератор sitemap не должен влиять на работу системы. Он должен генерироваться в фоне.               
1. Обязательно использовать docker для разработки. В данном репозитории уже создана заготовка. Можно использовать ее, а можно сделать свою.

### Контакты для связи:
telegram: @nazartsevEgor
