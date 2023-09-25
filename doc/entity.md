# Les entités

Doctrine est un ORM (Mapping Objet-Relationnel ou Object Relational Mapping) qui permet de faire la transition entre une base
de données et des objets PHP (Entités). 

Doctrine est également DBAL (Couche d'abstraction de base de données ou DataBase Abstraction
Layer) qui permet de créer des requêtes en fonction du moteur (MySQL, SQLServer) sans modifier le code PHP.

## Annotations

Pour donner des indications sur la structure de la table de données, nous utilisons principalement des annotations en utilisant les objets "Mapping" de Doctrine:

```php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Article
{

}
```

### Clé primaire

Dans la plupart des cas, il y a une clé primaire dans une table qui correspond à un id, un entier généré en auto incrémentation.

```php 
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Article
{
    #[ORM\Id] // Clé primaire
    #[ORM\GeneratedValue] // Auto increment
    #[ORM\Column]
    private ?int $id;
}
```
### Colonnes

L'annotation (ou attribut) *Column* permet de définir une colonne de la table de données, elle donne des instructions comme le type, la longeur si c'est une chaîne, si la donnée peut être nulle etc.

```php

#[ORM\Column(nullable: true, length: 100)]
private ?string $name;

```

Le type de données peut être par exemple:
- integer
- string
- date
- datetime
- boolean
- text
