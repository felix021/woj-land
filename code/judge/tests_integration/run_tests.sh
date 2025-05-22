#!/bin/bash

JUDGE_EXE="../judge_all.exe"
TEMP_DIR_JUDGE="temp_judge_run"

# Ensure judge_all.exe exists
if [ ! -f "$JUDGE_EXE" ]; then
    echo "FAIL: ${JUDGE_EXE} not found. Compile it in code/judge/ first."
    exit 1
fi
echo "Found judge executable at: ${JUDGE_EXE}"

# Test cases: dir_name problem_id expected_result_code language_code time_limit_ms
declare -a test_cases=(
    "001_c_ac 001 1 1 1000"      # C, AC (1), 1s
    "002_c_wa 002 5 1 1000"      # C, WA (5), 1s
    "003_c_tle 003 3 1 200"       # C, TLE (3), 200ms
)

total_tests=0
passed_tests=0

run_test_case() {
    local test_dir=$1
    local problem_id=$2
    local expected_result=$3
    local lang_code=$4
    local time_limit_ms=$5
    local source_file="source/p${problem_id}.c" # Assuming .c for now, can be parameterized later

    ((total_tests++))
    echo "-----------------------------------------------------"
    echo "RUNNING TEST: ${test_dir} (Problem ID: ${problem_id}, Lang: C, Expected: ${expected_result}, TL: ${time_limit_ms}ms)"

    # Clean and create temp directory for judge
    rm -rf "${TEMP_DIR_JUDGE}"
    mkdir -p "${TEMP_DIR_JUDGE}"
    if [ ! -d "${TEMP_DIR_JUDGE}" ]; then
        echo "FAIL: Could not create temp directory ${TEMP_DIR_JUDGE}"
        return 1 # Failure
    fi

    echo "Judge command: ${JUDGE_EXE} -l ${lang_code} -s ${test_dir}/${source_file} -n ${problem_id} -D ${test_dir}/data/ -d ${TEMP_DIR_JUDGE}/ -t ${time_limit_ms} -m 65536 -o 8192"
    
    # Run the judge
    judge_output=$(${JUDGE_EXE} \
        -l "${lang_code}" \
        -s "${test_dir}/${source_file}" \
        -n "${problem_id}" \
        -D "${test_dir}/data/" \
        -d "${TEMP_DIR_JUDGE}/" \
        -t "${time_limit_ms}" \
        -m 65536 \
        -o 8192)

    # Capture judge's exit code (optional, as result is on stdout)
    judge_exit_code=$? 
    echo "Judge raw output: '${judge_output}' (Exit code: ${judge_exit_code})"

    # Extract result_code from the first field of judge_output
    actual_result=$(echo "${judge_output}" | awk '{print $1}')

    if [ -z "$actual_result" ]; then
        echo "FAIL: ${test_dir} - Could not parse result from judge output: '${judge_output}'"
        # Log compiler/runtime errors if any exist
        if [ -f "${TEMP_DIR_JUDGE}/stderr_compiler.txt" ]; then
            echo "Compiler stderr:"
            cat "${TEMP_DIR_JUDGE}/stderr_compiler.txt"
        fi
        if [ -f "${TEMP_DIR_JUDGE}/stderr_executive.txt" ]; then
            echo "Executive stderr:"
            cat "${TEMP_DIR_JUDGE}/stderr_executive.txt"
        fi
        return 1 # Failure
    fi

    echo "Expected result: ${expected_result}, Actual result: ${actual_result}"

    if [ "${actual_result}" == "${expected_result}" ]; then
        echo "PASS: ${test_dir}"
        ((passed_tests++))
        return 0 # Success
    else
        echo "FAIL: ${test_dir} - Expected ${expected_result}, Got ${actual_result}"
        # Log compiler/runtime errors if any exist
        if [ -f "${TEMP_DIR_JUDGE}/stderr_compiler.txt" ] && [ -s "${TEMP_DIR_JUDGE}/stderr_compiler.txt" ]; then
            echo "Compiler stderr:"
            cat "${TEMP_DIR_JUDGE}/stderr_compiler.txt"
        fi
         if [ -f "${TEMP_DIR_JUDGE}/stdout_compiler.txt" ] && [ -s "${TEMP_DIR_JUDGE}/stdout_compiler.txt" ]; then
            echo "Compiler stdout:"
            cat "${TEMP_DIR_JUDGE}/stdout_compiler.txt"
        fi
        if [ -f "${TEMP_DIR_JUDGE}/stderr_executive.txt" ] && [ -s "${TEMP_DIR_JUDGE}/stderr_executive.txt" ]; then
            echo "Executive stderr:"
            cat "${TEMP_DIR_JUDGE}/stderr_executive.txt"
        fi
        if [ -f "${TEMP_DIR_JUDGE}/stdout_executive.txt" ] && [ -s "${TEMP_DIR_JUDGE}/stdout_executive.txt" ]; then
            echo "User program stdout:"
            cat "${TEMP_DIR_JUDGE}/stdout_executive.txt"
        fi
        return 1 # Failure
    fi
}

# Run all test cases
for test_case_params in "${test_cases[@]}"; do
    # Split parameters: test_dir problem_id expected_result lang_code time_limit_ms
    params=($test_case_params) 
    run_test_case "${params[0]}" "${params[1]}" "${params[2]}" "${params[3]}" "${params[4]}"
done

echo "-----------------------------------------------------"
echo "SUMMARY: Passed ${passed_tests} out of ${total_tests} tests."
echo "-----------------------------------------------------"

# Clean up temp directory one last time
rm -rf "${TEMP_DIR_JUDGE}"

if [ "${passed_tests}" == "${total_tests}" ]; then
    exit 0
else
    exit 1
fi
