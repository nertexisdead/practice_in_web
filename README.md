## Local deployment

* Install [Docker Desktop](https://www.docker.com/products/docker-desktop/)
* Clone project repo
* Run one of the required commands below

```bash
docker compose -f docker-compose.local.yml up -d
```

---

## Access locally deployed services

* Laravel project: [http://localhost:8080/](http://localhost:8080/)
* PGAdmin: [http://localhost:8081/](http://localhost:8081/)
* MinIO (S3 storage): [http://localhost:9001/](http://localhost:9001/)

---

## S3-compatible storage (MinIO)

Local environment includes S3-compatible storage via MinIO.

### API endpoint

```
http://localhost:9000
```

### Web console

```
http://localhost:9001
```

### Default credentials

```
Username: test
Password: 12345678
```

---

## Default bucket

Create bucket manually in MinIO console:

* Bucket name: `backet` (or `media`, depending on project config)

---

## Laravel S3 configuration

Make sure `.env` contains:

```env
FILESYSTEM_DISK=s3

AWS_ACCESS_KEY_ID=test
AWS_SECRET_ACCESS_KEY=12345678
AWS_DEFAULT_REGION=us-east-1

AWS_BUCKET=backet
AWS_ENDPOINT=http://minio:9000
AWS_USE_PATH_STYLE_ENDPOINT=true
```
