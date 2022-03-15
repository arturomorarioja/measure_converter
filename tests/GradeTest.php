<?php
/**
 * Integration tests for grading.
 * Components tested:
 * - Grade class
 * - Database
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0, March 2022
 */

    require_once 'src/grade.php';

    use PHPUnit\Framework\TestCase;

    class GradeTest extends TestCase {

        public function testConvert12Passes(): void {
            $grade = new Grade();

            $result = $grade->convert('12', GRADE::DENMARK);

            $this->assertEquals('A+', $result);
        }

        /**
         * @dataProvider ConvertPasses
         */
        public function testConvertPasses($gradeToConvert, $system, $expected): void {
            $grade = new Grade();

            $result = $grade->convert($gradeToConvert, $system);

            $this->assertEquals($expected, $result);
        }
        public function ConvertPasses(): array {
            return [
                ['12', Grade::DENMARK, 'A+'],
                ['10', Grade::DENMARK, 'A'],
                ['7', Grade::DENMARK, 'B'],
                ['4', Grade::DENMARK, 'C'],
                ['02', Grade::DENMARK, 'D'],
                ['00', Grade::DENMARK, 'F'],
                ['-3', Grade::DENMARK, 'F'],
                ['A+', Grade::USA, '12'],
                ['A', Grade::USA, '10'],
                ['B', Grade::USA, '7'],
                ['C', Grade::USA, '4'],
                ['D', Grade::USA, '02'],
                ['F', Grade::USA, '00'],
                ['K', Grade::USA, 'Invalid value']
            ];
        }

        //  No assertNotEquals are necessary,
        //  since they would simply test the opposite 
        //  of what ConvertPasses has already tested
        
    }

?>