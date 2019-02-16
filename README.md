# Symfony API

Alexandre GIANNETTO

Je n'ai pas réussis a gérer les `post` avec des `ManyToMany/… je n'ai donc pas su faire tout l'ajout/edit d'utilisateur/cartes`

Vous trouverez l'énoncé avec ma progression ainsi qu'un export postman de ce que j'ai fais dans le repo

doc : [http://localhost/api/doc](http://localhost/api/doc)


## installation:
```bash
git clone https://github.com/Alexg78bis/IPSSI-SymfonyAPI
cd IPSSI-SymfonyAPI
composer install
docker-compose exec web php bin/console d:s:u --force
docker-compose exec web php bin/console hautelook:fixtures:load --purge-with-truncate
```

## commandes :
- fixtures: 
```bash
docker-compose exec web php bin/console doctrine:fixtures:load 
```

- Ajout d'un admin: 
```bash
php bin/console app:create-admin {email}
```

- Récupérer le nombre de carte d'un utilisateur:
```bash
docker-compose exec web php bin/console app:CardNumber {email}
```
