#include <stdio.h>

void main(void) {

  char Check[8] = {0x00,};
  char Name[10] = {0x00,};
  char Pass[10] = {0x00,};

  printf("Name:");
  scanf("%s", Name);
  printf("Pass:");
  scanf("%s", Pass);
  if (strcmp(Name, "user") == 0 && strcmp(Pass, "qweqwe") == 0) {
    Check[0]= 1;
  }

  if (Check[0] != 0) {
    printf("success.\n");
  } else {
    printf("error\n");
  }
}
