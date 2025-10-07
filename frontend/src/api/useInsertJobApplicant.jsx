import { useState } from "react";
import axios from "./axiosInstance";

const useInsertJobApplicant = () => {
  const [response, setResponse] = useState("");
  const [loadingForJobApplicant, setLoadingForJobApplicant] = useState(false);
  const [errorForJobApplicant, setErrorForJobApplicant] = useState("");

  const insertJobApplicant = async (jobApplicant) => {
    try {
      setLoadingForJobApplicant(true);
      const response = await axios.post(
        "/insertJobApplicant.php",
        jobApplicant
      );
      setResponse(response.data);
    } catch (error) {
      setErrorForJobApplicant(error);
    }
    setLoadingForJobApplicant(false);
  };

  return {
    response,
    insertJobApplicant,
    loadingForJobApplicant,
    errorForJobApplicant,
  };
};

export default useInsertJobApplicant;
