let arrayList = [1,3,5,6,11,23];
let sum = 9;

const twoSum = (arr, sum) =>{

    for(let i of arr){
        for (let j of arr){
            if(i + j !=sum){
                continue
            }return `This is ${i} : ${j}`
        }
    }
}

console.log(twoSum(arrayList, sum));