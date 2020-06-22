FROM postgres:12-alpine

COPY postgresql.conf /postgresql.conf
COPY /postgresql.conf /etc/postgresql/postgresql.conf

RUN apk add tzdata
RUN cp /usr/share/zoneinfo/America/Recife /etc/localtime
RUN echo "America/Recife" >  /etc/timezone