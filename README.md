## How to run

To run the container with application please execute following:
```bash
git clone git@github.com:userqq/marbill.git
docker-compose up --build -d
```

## How to use
The application will starts on 41337 port (you could change to desired port in docker-compose.yml file in `services.web.ports` section)
Authorization implemented using HTTP Basic AUTH. Default login `marbill` and password `marbill`. 
