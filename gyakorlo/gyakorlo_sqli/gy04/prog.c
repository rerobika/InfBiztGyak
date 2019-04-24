#include <stdio.h>

void work(const char *msg) {
    int db=0;
    int i=0;
    int local[4];
    printf("\n::");
    printf(msg);
    printf("darabszam: ");
    scanf("%d", &db);
    while(i < db) {
        printf("%d:", i);
        scanf("%x", local+i++);
    }
    printf("\n::");
    printf(msg);
}

int main() {
    char buff[256];
    volatile int secret = SECRET;
    printf("Input: ");
    fgets(buff, 256, stdin);
    work(buff);
    if(secret != SECRET) {
        printf("%s\n", MESSAGE);
    }
    return 0;
}
