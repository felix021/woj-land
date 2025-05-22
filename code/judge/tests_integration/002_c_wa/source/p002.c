#include <stdio.h>
int main() {
    int a, b;
    if (scanf("%d %d", &a, &b) == 2) {
        printf("%d\n", a - b); // Intentionally wrong
    }
    return 0;
}
